<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    /**
     * Tiếp nhận Webhook thanh toán tự động từ Ngân hàng (Hỗ trợ SePay, PayOS, Casso, VietQR)
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        Log::info('Payment Webhook Received:', $request->except(['api_key']));

        // Kiểm tra API Key / Token (bắt buộc trên môi trường không phải local)
        $configuredApiKey = config('services.sepay.api_key') ?? env('SEPAY_API_KEY');
        if (empty($configuredApiKey) && !app()->isLocal()) {
            Log::error('Payment Webhook rejected: SEPAY_API_KEY is not configured.');
            return response()->json([
                'success' => false,
                'message' => 'Webhook authentication is not configured.'
            ], 503);
        }

        if (!empty($configuredApiKey)) {
            $receivedToken = (string) (
                $request->header('Authorization')
                ?? $request->header('X-Api-Key')
                ?? $request->input('api_key')
                ?? ''
            );

            // Xử lý tiền tố "Apikey " hoặc "Bearer " nếu có
            if (str_starts_with($receivedToken, 'Apikey ')) {
                $receivedToken = substr($receivedToken, 7);
            } elseif (str_starts_with($receivedToken, 'Bearer ')) {
                $receivedToken = substr($receivedToken, 7);
            }

            if (!hash_equals((string) $configuredApiKey, trim($receivedToken))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Invalid Webhook API Key'
                ], 401);
            }
        }

        // 0. Bỏ qua giao dịch tiền RA (transferType = 'out') từ SePay (ví dụ hoàn tiền)
        $transferType = strtolower(trim((string) ($request->input('transferType') ?? $request->input('data.transferType') ?? 'in')));
        if ($transferType !== '' && $transferType !== 'in') {
            return response()->json([
                'success' => true,
                'message' => 'Bỏ qua giao dịch tiền ra (transferType: ' . $transferType . ').'
            ], 200);
        }

        // 1. Trích xuất nội dung chuyển khoản (Content / Description)
        $content = $request->input('content')
            ?? $request->input('description')
            ?? $request->input('data.description')
            ?? $request->input('orderCode')
            ?? '';

        // 2. Trích xuất số tiền chuyển (bắt buộc > 0)
        $amount = floatval(
            $request->input('transferAmount')
            ?? $request->input('amount')
            ?? $request->input('data.amount')
            ?? 0
        );

        if ($amount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Số tiền giao dịch không hợp lệ (phải lớn hơn 0).'
            ], 422);
        }

        // 3. Trích xuất cổng / ngân hàng thanh toán & mã tham chiếu chống trùng lặp
        $gateway = $request->input('gateway')
            ?? $request->input('bank')
            ?? $request->input('data.accountNumber')
            ?? 'Chuyển khoản VietQR';
        $referenceCode = trim((string) (
            $request->input('referenceCode')
            ?? $request->input('id')
            ?? $request->input('data.reference')
            ?? ''
        ));
        $paymentMethodLabel = $referenceCode !== ''
            ? ($gateway . ' [Ref:' . $referenceCode . ']')
            : $gateway;

        // 4. Tìm mã hóa đơn (invoice_code) trong nội dung chuyển khoản
        $invoiceCode = null;
        if (preg_match('/(HD[A-Z0-9]+)/i', (string) $content, $matches)) {
            $invoiceCode = strtoupper($matches[1]);
        } elseif ($request->filled('invoice_code')) {
            $invoiceCode = strtoupper(trim((string) $request->input('invoice_code')));
        } elseif ($request->filled('data.orderCode')) {
            $invoiceCode = 'HD' . trim((string) $request->input('data.orderCode'));
        }

        if (!$invoiceCode) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy mã hóa đơn (HD...) trong nội dung thanh toán.'
            ], 422);
        }

        // 5-7. Khóa dòng hóa đơn trong Transaction để chống thanh toán trùng lặp (race condition & webhook retry)
        $result = DB::transaction(function () use ($invoiceCode, $paymentMethodLabel, $referenceCode, $amount) {
            $invoice = Invoice::where('invoice_code', $invoiceCode)->lockForUpdate()->first();

            if (!$invoice) {
                return ['code' => 404, 'payload' => [
                    'success' => false,
                    'message' => "Không tìm thấy hóa đơn {$invoiceCode} trong hệ thống."
                ]];
            }

            if ($invoice->status === 'paid') {
                return ['code' => 200, 'payload' => [
                    'success' => true,
                    'message' => "Hóa đơn #{$invoice->invoice_code} đã hoàn tất thanh toán trước đó.",
                    'invoice_code' => $invoice->invoice_code,
                    'status' => 'paid'
                ]];
            }

            if ($invoice->status !== 'unpaid') {
                return ['code' => 409, 'payload' => [
                    'success' => false,
                    'message' => "Hóa đơn #{$invoice->invoice_code} đang ở trạng thái '{$invoice->status}', không thể tiếp nhận thanh toán."
                ]];
            }

            if ($referenceCode !== '') {
                $alreadyProcessed = $invoice->payments()
                    ->where('payment_method', 'like', '%[Ref:' . $referenceCode . ']%')
                    ->exists();
                if ($alreadyProcessed) {
                    return ['code' => 200, 'payload' => [
                        'success' => true,
                        'message' => "Giao dịch Ref:{$referenceCode} đã được ghi nhận trước đó.",
                        'invoice_code' => $invoice->invoice_code,
                        'status' => $invoice->status,
                    ]];
                }
            }

            Payment::create([
                'invoice_id' => $invoice->id,
                'payment_method' => $paymentMethodLabel,
                'amount' => $amount,
                'status' => 'completed',
            ]);

            $totalPaid = floatval($invoice->payments()->where('status', 'completed')->sum('amount'));
            $deductedCount = 0;

            if ($totalPaid >= floatval($invoice->final_amount)) {
                $invoice->update(['status' => 'paid']);
                $deductedCount = $invoice->deductMedicineStock();
            }

            Log::info("Invoice #{$invoice->invoice_code} processed via Webhook. Paid: {$totalPaid}/{$invoice->final_amount}, Status: {$invoice->status}, Deducted: {$deductedCount}");

            return ['code' => 200, 'payload' => [
                'success' => true,
                'message' => 'Xác nhận thanh toán tự động thành công!',
                'invoice_code' => $invoice->invoice_code,
                'status' => $invoice->status,
                'final_amount' => floatval($invoice->final_amount),
                'total_paid' => $totalPaid,
                'deducted_medicines' => $deductedCount
            ]];
        });

        return response()->json($result['payload'], $result['code']);
    }

    /**
     * API kiểm tra trạng thái hóa đơn thời gian thực (hỗ trợ trang Bệnh nhân tự động cập nhật)
     */
    public function checkStatus(string $code): JsonResponse
    {
        $invoice = Invoice::where('invoice_code', strtoupper(trim($code)))->first();

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
     * API mô phỏng thanh toán nhanh (Chỉ dành cho kiểm thử / demo trên môi trường cục bộ)
     */
    public function simulate(Request $request): JsonResponse
    {
        if (!app()->isLocal()) {
            return response()->json([
                'success' => false,
                'message' => 'Chức năng mô phỏng thanh toán chỉ khả dụng trên môi trường cục bộ.'
            ], 403);
        }

        $code = strtoupper(trim((string) ($request->input('invoice_code') ?? $request->input('code') ?? '')));

        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng cung cấp mã hóa đơn (invoice_code)'
            ], 422);
        }

        $invoice = Invoice::where('invoice_code', $code)->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy hóa đơn trong hệ thống.'
            ], 404);
        }

        $payload = [
            'gateway' => 'VietQR Techcombank (Mô phỏng)',
            'content' => 'THANH TOAN ' . $invoice->invoice_code,
            'transferAmount' => floatval($invoice->final_amount),
            'referenceCode' => 'SIMULATE_' . strtoupper(substr(md5(uniqid()), 0, 8)),
        ];

        $configuredApiKey = config('services.sepay.api_key') ?? env('SEPAY_API_KEY');
        if (!empty($configuredApiKey)) {
            $payload['api_key'] = $configuredApiKey;
        }

        $fakeRequest = new Request($payload);

        return $this->handleWebhook($fakeRequest);
    }
}
