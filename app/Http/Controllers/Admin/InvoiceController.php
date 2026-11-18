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
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['patient', 'appointment']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('invoice_code', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $invoices = $query->latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    private function ensureDefaultMedicinesAndServices(): void
    {
        if (Service::count() === 0) {
            $defaultServices = [
                ['service_code' => 'SV001', 'name' => 'Khám tổng quát & Tư vấn nha khoa', 'price' => 100000, 'duration_minutes' => 15, 'is_active' => true],
                ['service_code' => 'SV002', 'name' => 'Cạo vôi răng & Đánh bóng 2 hàm', 'price' => 250000, 'duration_minutes' => 30, 'is_active' => true],
                ['service_code' => 'SV003', 'name' => 'Trám răng thẩm mỹ Composite', 'price' => 350000, 'duration_minutes' => 30, 'is_active' => true],
                ['service_code' => 'SV004', 'name' => 'Điều trị tủy răng chuyên sâu', 'price' => 800000, 'duration_minutes' => 45, 'is_active' => true],
                ['service_code' => 'SV005', 'name' => 'Nhổ răng khôn không đau (Piezotome)', 'price' => 1500000, 'duration_minutes' => 45, 'is_active' => true],
                ['service_code' => 'SV006', 'name' => 'Tẩy trắng răng Laser Whitening', 'price' => 2500000, 'duration_minutes' => 60, 'is_active' => true],
            ];
            foreach ($defaultServices as $srv) {
                Service::firstOrCreate(['name' => $srv['name']], $srv);
            }
        }

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
        $vatSetting = SystemSetting::where('setting_key', 'vat_percentage')->first();
        $vatRate = ($vatSetting && floatval($vatSetting->setting_value) > 0) ? floatval($vatSetting->setting_value) : 10;

        return view('admin.invoices.create', compact('patients', 'appointments', 'services', 'medicines', 'vatRate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:unpaid,paid,cancelled',
        ], [
            'items.required' => 'Vui lòng tích chọn ít nhất 1 Dịch vụ khám hoặc Thuốc.',
            'items.min' => 'Vui lòng tích chọn ít nhất 1 Dịch vụ khám hoặc Thuốc.',
        ]);

        $vatSetting = SystemSetting::where('setting_key', 'vat_percentage')->first();
        $vatRate = ($vatSetting && floatval($vatSetting->setting_value) > 0) ? floatval($vatSetting->setting_value) : 10;

        $total = 0;
        foreach ($request->items as $item) {
            $total += ($item['price'] * $item['quantity']);
        }

        $discount = $request->discount ?? 0;
        $afterDiscount = max(0, $total - $discount);
        $vat = $afterDiscount * ($vatRate / 100);
        $final = $afterDiscount + $vat;

        $invoice = Invoice::create([
            'invoice_code' => 'HD' . date('YmdHis'),
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'total_amount' => $total,
            'discount' => $discount,
            'vat_amount' => $vat,
            'final_amount' => $final,
            'status' => $request->status,
        ]);

        foreach ($request->items as $item) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['name'],
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        if ($request->status === 'paid') {
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
        $invoice->load('details');
        $patients = Patient::orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $medicines = Medicine::orderBy('name')->get();
        $appointments = Appointment::with('patient', 'service')->get();
        $vatSetting = SystemSetting::where('setting_key', 'vat_percentage')->first();
        $vatRate = ($vatSetting && floatval($vatSetting->setting_value) > 0) ? floatval($vatSetting->setting_value) : 10;

        return view('admin.invoices.edit', compact('invoice', 'patients', 'appointments', 'services', 'medicines', 'vatRate'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:unpaid,paid,cancelled',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
        ]);

        $vatSetting = SystemSetting::where('setting_key', 'vat_percentage')->first();
        $vatRate = ($vatSetting && floatval($vatSetting->setting_value) > 0) ? floatval($vatSetting->setting_value) : 10;

        $total = 0;
        foreach ($request->items as $item) {
            $total += ($item['price'] * $item['quantity']);
        }

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
        foreach ($request->items as $item) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['name'],
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        if ($previousStatus !== 'paid' && $request->status === 'paid') {
            $invoice->deductMedicineStock();
        }

        return redirect()->route('admin.invoices.index')->with('success', 'Cập nhật hóa đơn thành công!');
    }

    public function refund(Request $request, Invoice $invoice)
    {
        $invoice->update(['status' => 'cancelled']);
        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Đã chuyển trạng thái hóa đơn #' . $invoice->invoice_code . ' sang Đã hủy / Hoàn trả.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Đã xóa hóa đơn!');
    }
}
