<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    /**
     * Tiếp nhận Webhook thanh toán tự động từ Ngân hàng (Hỗ trợ SePay, PayOS, Casso, VietQR)
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        Log::info('Payment Webhook Received:', $request->all());

        // Kiểm tra API Key / Token nếu được cấu hình trong .env (tùy chọn bảo mật)
        $configuredApiKey = config('services.sepay.api_key') ?? env('SEPAY_API_KEY');
        if (!empty($configuredApiKey)) {
            $receivedToken = $request->header('Authorization') 
                ?? $request->header('X-Api-Key') 
                ?? $request->input('api_key');
            
            // Xử lý tiền tố "Apikey " nếu có
            if (str_starts_with($receivedToken ?? '', 'Apikey ')) {
                $receivedToken = substr($receivedToken, 7);
            }

            if ($receivedToken !== $configuredApiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Invalid Webhook API Key'
                ], 401);
            }
        }

        // 1. Trích xuất nội dung chuyển khoản (Content / Description)
        $content = $request->input('content') 
            ?? $request->input('description') 
            ?? $request->input('data.description') 
            ?? $request->input('orderCode') 
            ?? '';

        // 2. Trích xuất số tiền chuyển
        $amount = floatval(
            $request->input('transferAmount') 
            ?? $request->input('amount') 
            ?? $request->input('data.amount') 
            ?? 0
        );

        // 3. Trích xuất cổng / ngân hàng thanh toán
        $gateway = $request->input('gateway') 
            ?? $request->input('bank') 
            ?? $request->input('data.accountNumber') 
            ?? 'Chuyển khoản VietQR';

        // 4. Tìm mã hóa đơn (invoice_code) trong nội dung chuyển khoản
        // Mẫu mã hóa đơn thường là HD + chuỗi số (ví dụ HD20261118123000)
        $invoiceCode = null;
        if (preg_match('/(HD\d+)/i', (string) $content, $matches)) {
            $invoiceCode = strtoupper($matches[1]);
        } elseif ($request->filled('invoice_code')) {
            $invoiceCode = strtoupper($request->input('invoice_code'));
        } elseif ($request->filled('data.orderCode')) {
            $invoiceCode = 'HD' . $request->input('data.orderCode');
        }

        if (!$invoiceCode) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy mã hóa đơn (HD...) trong nội dung thanh toán: ' . $content
            ], 422);
        }

        // 5. Tìm hóa đơn trong cơ sở dữ liệu
        $invoice = Invoice::where('invoice_code', $invoiceCode)->first();

        // Nếu không khớp mã dạng text, thử tìm theo ID
        if (!$invoice && is_numeric(str_replace('HD', '', $invoiceCode))) {
            $invoice = Invoice::find(intval(str_replace('HD', '', $invoiceCode)));
        }

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy hóa đơn {$invoiceCode} trong hệ thống."
            ], 404);
        }

        // Nếu hóa đơn đã được thanh toán từ trước
        if ($invoice->status === 'paid') {
            return response()->json([
                'success' => true,
                'message' => "Hóa đơn #{$invoice->invoice_code} đã hoàn tất thanh toán trước đó.",
                'invoice_code' => $invoice->invoice_code,
                'status' => 'paid'
            ]);
        }

        // 6. Ghi nhận giao dịch Payment
        $actualPaymentAmount = ($amount > 0) ? $amount : floatval($invoice->final_amount);
        Payment::create([
            'invoice_id' => $invoice->id,
            'payment_method' => $gateway,
            'amount' => $actualPaymentAmount,
            'status' => 'completed',
        ]);

        // 7. Kiểm tra tổng tiền đã thanh toán và cập nhật trạng thái hóa đơn
        $totalPaid = floatval($invoice->payments()->where('status', 'completed')->sum('amount'));
        $deductedCount = 0;

        if ($totalPaid >= floatval($invoice->final_amount)) {
            $invoice->update(['status' => 'paid']);

            // Tự động trừ tồn kho dược
            $deductedCount = $invoice->deductMedicineStock();
        }

        Log::info("Invoice #{$invoice->invoice_code} auto-updated to paid via Webhook. Deducted: {$deductedCount} items.");

        return response()->json([
            'success' => true,
            'message' => 'Xác nhận thanh toán tự động thành công!',
            'invoice_code' => $invoice->invoice_code,
            'status' => $invoice->status,
            'final_amount' => floatval($invoice->final_amount),
            'total_paid' => $totalPaid,
            'deducted_medicines' => $deductedCount
        ]);
    }

    /**
     * API kiểm tra trạng thái hóa đơn thời gian thực (hỗ trợ trang Bệnh nhân tự động cập nhật)
     */
    public function checkStatus(string $code): JsonResponse
    {
        $invoice = Invoice::where('invoice_code', $code)->first();

        if (!$invoice && is_numeric($code)) {
            $invoice = Invoice::find(intval($code));
        }

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy hóa đơn.'
            ], 404);
        }

        $totalPaid = floatval($invoice->payments()->where('status', 'completed')->sum('amount'));

        return response()->json([
            'success' => true,
            'invoice_code' => $invoice->invoice_code,
            'status' => $invoice->status,
            'is_paid' => ($invoice->status === 'paid'),
            'final_amount' => floatval($invoice->final_amount),
            'total_paid' => $totalPaid,
            'paid_at' => ($invoice->status === 'paid') ? $invoice->updated_at->format('d/m/Y H:i:s') : null,
        ]);
    }

    /**
     * API mô phỏng thanh toán nhanh (Dành cho việc kiểm thử / demo trên môi trường cục bộ)
     */
    public function simulate(Request $request): JsonResponse
    {
        $code = $request->input('invoice_code') ?? $request->input('code');

        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng cung cấp mã hóa đơn (invoice_code)'
            ], 422);
        }

        $invoice = Invoice::where('invoice_code', $code)->first();
        if (!$invoice && is_numeric($code)) {
            $invoice = Invoice::find(intval($code));
        }

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy hóa đơn trong hệ thống.'
            ], 404);
        }

        // Tạo request giả lập gọi vào handleWebhook
        $fakeRequest = new Request([
            'gateway' => 'VietQR Techcombank (Mô phỏng)',
            'content' => 'THANH TOAN ' . $invoice->invoice_code,
            'transferAmount' => floatval($invoice->final_amount),
            'referenceCode' => 'SIMULATE_' . strtoupper(substr(md5(uniqid()), 0, 8)),
        ]);

        return $this->handleWebhook($fakeRequest);
    }
}
