<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Medicine;
use App\Models\SystemSetting;
use App\Support\InvoiceItemCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    private function getVatRate(): float
    {
        $vatSetting = SystemSetting::where('setting_key', 'vat_percentage')->first();
        if ($vatSetting && $vatSetting->setting_value !== '' && is_numeric($vatSetting->setting_value)) {
            return max(0, floatval($vatSetting->setting_value));
        }
        return 10.0;
    }

    public function index(Request $request)
    {
        $query = Invoice::with(['patient', 'appointment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                  ->orWhereHas('patient', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('patient_code', 'like', "%{$search}%");
                  });
            });
        }

        $invoices = $query->latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    private function ensureDefaultMedicinesAndServices(): void
    {

        if (Medicine::count() === 0) {
            $defaultMedicines = [
                ['name' => 'Gói thuốc kháng viêm - giảm đau cơ bản (3 ngày)', 'category' => 'Gói đơn thuốc', 'unit' => 'Liệu trình', 'import_price' => 60000, 'price' => 120000, 'stock_quantity' => 100],
                ['name' => 'Gói thuốc sau nhổ răng khôn / Tiểu phẫu (5 ngày)', 'category' => 'Gói đơn thuốc', 'unit' => 'Liệu trình', 'import_price' => 130000, 'price' => 250000, 'stock_quantity' => 100],
                ['name' => 'Kháng sinh Amoxicillin + Acid Clavulanic 625mg', 'category' => 'Kháng sinh', 'unit' => 'Hộp (14 viên)', 'import_price' => 65000, 'price' => 95000, 'stock_quantity' => 80],
                ['name' => 'Thuốc giảm đau - kháng viêm Ibuprofen 400mg', 'category' => 'Giảm đau', 'unit' => 'Vỉ (10 viên)', 'import_price' => 15000, 'price' => 30000, 'stock_quantity' => 150],
                ['name' => 'Thuốc chống phù nề Alpha Choay', 'category' => 'Chống viêm', 'unit' => 'Hộp (20 viên)', 'import_price' => 45000, 'price' => 65000, 'stock_quantity' => 120],
                ['name' => 'Nước súc miệng sát khuẩn Chlorhexidine 0.12%', 'category' => 'Chăm sóc răng', 'unit' => 'Chai 250ml', 'import_price' => 55000, 'price' => 85000, 'stock_quantity' => 90],
                ['name' => 'Gel bôi nhiệt miệng & viêm lợi Kamistad-Gel N', 'category' => 'Thuốc bôi', 'unit' => 'Tuýp 10g', 'import_price' => 38000, 'price' => 55000, 'stock_quantity' => 70],
            ];
            foreach ($defaultMedicines as $med) {
                Medicine::firstOrCreate(['name' => $med['name']], $med);
            }
        } else {
            Medicine::where('price', '<=', 0)->update(['price' => 50000]);
        }
    }

    public function create()
    {
        $this->ensureDefaultMedicinesAndServices();
        $patients = Patient::orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $medicines = Medicine::orderBy('name')->get();
        $appointments = Appointment::with(['patient', 'service'])->whereIn('status', ['completed', 'in_progress', 'waiting', 'confirmed'])->latest('appointment_time')->get();
        $vatRate = $this->getVatRate();

        return view('admin.invoices.create', compact('patients', 'appointments', 'services', 'medicines', 'vatRate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'nullable|integer|exists:services,id',
            'items.*.medicine_id' => 'nullable|integer|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:unpaid,paid,cancelled',
        ], [
            'items.required' => 'Vui lòng tích chọn ít nhất 1 Dịch vụ khám hoặc Thuốc.',
            'items.min' => 'Vui lòng tích chọn ít nhất 1 Dịch vụ khám hoặc Thuốc.',
        ]);

        $items = InvoiceItemCatalog::normalize($request->items);
        $vatRate = $this->getVatRate();
        $total = array_sum(array_column($items, 'total_price'));

        $discount = $request->discount ?? 0;
        $afterDiscount = max(0, $total - $discount);
        $vat = $afterDiscount * ($vatRate / 100);
        $final = $afterDiscount + $vat;

        $invoice = Invoice::create([
            'invoice_code' => 'HD' . date('YmdHis') . random_int(100, 999),
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'total_amount' => $total,
            'discount' => $discount,
            'vat_amount' => $vat,
            'final_amount' => $final,
            'status' => $request->status,
        ]);

        foreach ($items as $item) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'service_id' => $item['service_id'],
                'medicine_id' => $item['medicine_id'],
                'item_name' => $item['item_name'],
                'unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
            ]);
        }

        if ($request->status === 'paid') {
            \App\Models\Payment::create([
                'invoice_id' => $invoice->id,
                'payment_method' => 'Tiền mặt (Admin xác nhận)',
                'amount' => $final,
                'status' => 'completed',
            ]);
            $invoice->deductMedicineStock();
        }

        return redirect()->route('admin.invoices.index')->with('success', 'Tạo hóa đơn tự động thành công!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment.doctor.user', 'appointment.medicalRecord.prescription.details', 'details']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $this->ensureDefaultMedicinesAndServices();
        $invoice->load(['patient', 'details', 'appointment.doctor.user', 'appointment.medicalRecord.prescription.details.medicine']);

        // Chỉ tự động đồng bộ từ ca khám Bác sĩ nếu hóa đơn chưa có dòng chi tiết nào
        if ($invoice->status === 'unpaid' && $invoice->details->isEmpty() && $invoice->appointment && $invoice->appointment->medicalRecord) {
            $medRec = $invoice->appointment->medicalRecord;
            $hasAnyChange = false;

            if ($medRec->details && $medRec->details->count() > 0) {
                foreach ($medRec->details as $dDetail) {
                    if ($dDetail->service) {
                        $sName = $dDetail->service->name;
                        $alreadyExists = $invoice->details->contains(function ($d) use ($sName) {
                            return str_contains(mb_strtolower($d->item_name), mb_strtolower($sName));
                        });
                        if (!$alreadyExists) {
                            $price = floatval($dDetail->service->price);
                            $qty = max(1, intval($dDetail->quantity));
                            $itemLabel = 'Dịch vụ: ' . $sName;
                            if (!empty($dDetail->note)) {
                                $itemLabel .= ' (' . $dDetail->note . ')';
                            }
                            InvoiceDetail::create([
                                'invoice_id' => $invoice->id,
                                'service_id' => $dDetail->service->id,
                                'item_name' => $itemLabel,
                                'unit_price' => $price,
                                'quantity' => $qty,
                                'total_price' => $price * $qty,
                            ]);
                            $hasAnyChange = true;
                        }
                    }
                }
            }

            if ($medRec->prescription && $medRec->prescription->details) {
                foreach ($medRec->prescription->details as $pDetail) {
                    $alreadyExists = $invoice->details->contains(function ($d) use ($pDetail) {
                        return str_contains(mb_strtolower($d->item_name), mb_strtolower($pDetail->medicine_name));
                    });
                    if (!$alreadyExists) {
                        $medPrice = ($pDetail->medicine && floatval($pDetail->medicine->price) > 0) ? floatval($pDetail->medicine->price) : 15000;
                        $unitLabel = ($pDetail->medicine && $pDetail->medicine->unit) ? $pDetail->medicine->unit : ($pDetail->dosage ?: 'Đơn vị');
                        $qty = max(1, intval($pDetail->quantity));
                        InvoiceDetail::create([
                            'invoice_id' => $invoice->id,
                            'medicine_id' => $pDetail->medicine_id,
                            'item_name' => 'Thuốc: ' . $pDetail->medicine_name . ' (' . $unitLabel . ')',
                            'unit_price' => $medPrice,
                            'quantity' => $qty,
                            'total_price' => $medPrice * $qty,
                        ]);
                        $hasAnyChange = true;
                    }
                }
            }

            if ($hasAnyChange) {
                $invoice->load('details');
                $totalAmount = $invoice->details->sum('total_price');
                $discount = floatval($invoice->discount ?? 0);
                $afterDiscount = max(0, $totalAmount - $discount);
                $vatRate = $this->getVatRate();
                $vatAmount = $afterDiscount * ($vatRate / 100);
                $invoice->update([
                    'total_amount' => $totalAmount,
                    'vat_amount' => $vatAmount,
                    'final_amount' => $afterDiscount + $vatAmount,
                ]);
                $invoice->refresh()->load(['details']);
            }
        }

        $patients = Patient::orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $medicines = Medicine::orderBy('name')->get();
        $appointments = Appointment::with('patient', 'service')->get();
        $vatRate = $this->getVatRate();

        return view('admin.invoices.edit', compact('invoice', 'patients', 'appointments', 'services', 'medicines', 'vatRate'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:unpaid,paid,cancelled',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'nullable|integer|exists:services,id',
            'items.*.medicine_id' => 'nullable|integer|exists:medicines,id',
            'items.*.existing_detail_id' => 'nullable|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
        ]);

        $items = InvoiceItemCatalog::normalize($request->items, $invoice);
        $vatRate = $this->getVatRate();
        $total = array_sum(array_column($items, 'total_price'));

        $discount = $request->discount ?? 0;
        $afterDiscount = max(0, $total - $discount);
        $vat = $afterDiscount * ($vatRate / 100);
        $final = $afterDiscount + $vat;

        $previousStatus = $invoice->status;

        $invoice->update([
            'total_amount' => $total,
            'discount' => $discount,
            'vat_amount' => $vat,
            'final_amount' => $final,
            'status' => $request->status,
        ]);

        $invoice->details()->delete();
        foreach ($items as $item) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'service_id' => $item['service_id'],
                'medicine_id' => $item['medicine_id'],
                'item_name' => $item['item_name'],
                'unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
            ]);
        }

        if ($previousStatus !== 'paid' && $request->status === 'paid') {
            $alreadyPaid = floatval($invoice->payments()->where('status', 'completed')->sum('amount'));
            $remaining = max(0, $final - $alreadyPaid);
            if ($remaining > 0) {
                \App\Models\Payment::create([
                    'invoice_id' => $invoice->id,
                    'payment_method' => 'Tiền mặt (Admin xác nhận)',
                    'amount' => $remaining,
                    'status' => 'completed',
                ]);
            }
            $invoice->deductMedicineStock();
        }

        return redirect()->route('admin.invoices.index')->with('success', 'Cập nhật hóa đơn thành công!');
    }

    public function refund(Request $request, Invoice $invoice)
    {
        $result = DB::transaction(function () use ($invoice) {
            $lockedInvoice = Invoice::where('id', $invoice->id)->lockForUpdate()->firstOrFail();

            if ($lockedInvoice->status === 'cancelled') {
                return ['error' => 'Hóa đơn #' . $lockedInvoice->invoice_code . ' đã ở trạng thái hủy/hoàn trả trước đó.'];
            }

            $lockedInvoice->payments()->where('status', 'completed')->update(['status' => 'refunded']);
            $lockedInvoice->update(['status' => 'cancelled']);

            return ['success' => 'Đã chuyển trạng thái hóa đơn #' . $lockedInvoice->invoice_code . ' sang Đã hủy / Hoàn trả và cập nhật trạng thái giao dịch.'];
        });

        if (isset($result['error'])) {
            return redirect()->route('admin.invoices.show', $invoice)->with('error', $result['error']);
        }

        return redirect()->route('admin.invoices.show', $invoice)->with('success', $result['success']);
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return redirect()->route('admin.invoices.index')->with('error', 'Không thể xóa hóa đơn đã thanh toán. Vui lòng sử dụng chức năng Hoàn trả / Hủy hóa đơn để bảo toàn lịch sử tài chính.');
        }

        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Đã xóa hóa đơn!');
    }
}
