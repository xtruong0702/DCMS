<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Medicine;
use App\Models\SystemSetting;
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
            $search = $request->search;
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
        return view('receptionist.invoices.index', compact('invoices'));
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
            // Đảm bảo thuốc trong kho nếu chưa có giá bán thì có giá mặc định hợp lý
            Medicine::where('price', '<=', 0)->update(['price' => 50000]);
        }
    }

    public function create(Request $request)
    {
        $this->ensureDefaultMedicinesAndServices();

        $appointment = null;
        if ($request->filled('appointment_id')) {
            $appointment = Appointment::with([
                'patient',
                'service',
                'medicalRecord.details.service',
                'medicalRecord.prescription.details.medicine'
            ])->find($request->appointment_id);
        }

        $patients = Patient::orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $medicines = Medicine::orderBy('name')->get();
        $appointments = Appointment::with([
                'patient',
                'service',
                'medicalRecord.details.service',
                'medicalRecord.prescription.details.medicine'
            ])
            ->whereIn('status', ['completed', 'in_progress', 'waiting', 'confirmed'])
            ->latest('appointment_time')
            ->limit(50)
            ->get();

        $vatRate = $this->getVatRate();
        
        return view('receptionist.invoices.create', compact('appointment', 'patients', 'services', 'medicines', 'appointments', 'vatRate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0'
        ], [
            'items.required' => 'Vui lòng tích chọn ít nhất 1 Dịch vụ khám hoặc Thuốc để lập hóa đơn.',
            'items.min' => 'Vui lòng tích chọn ít nhất 1 Dịch vụ khám hoặc Thuốc để lập hóa đơn.',
        ]);

        $vatRate = $this->getVatRate();

        $totalAmount = 0;
        foreach ($request->items as $item) {
            $totalAmount += ($item['price'] * $item['quantity']);
        }

        $discount = $request->discount ?? 0;
        $amountAfterDiscount = max(0, $totalAmount - $discount);
        $vatAmount = $amountAfterDiscount * ($vatRate / 100);
        $finalAmount = $amountAfterDiscount + $vatAmount;

        $invoice = Invoice::create([
            'invoice_code' => 'HD' . date('YmdHis') . random_int(100, 999),
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'total_amount' => $totalAmount,
            'discount' => $discount,
            'vat_amount' => $vatAmount,
            'final_amount' => $finalAmount,
            'status' => 'unpaid'
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

        return redirect()->route('receptionist.invoices.show', $invoice)->with('success', 'Đã tạo hóa đơn tự động thành công.');
    }

    public function show(Invoice $invoice)
    {
        $this->ensureDefaultMedicinesAndServices();
        $invoice->load(['patient', 'details', 'payments', 'appointment.doctor.user', 'appointment.medicalRecord.prescription.details.medicine']);

        // Chỉ tự động đồng bộ từ ca khám Bác sĩ nếu hóa đơn chưa có dòng chi tiết nào (tránh ghi đè chỉnh sửa của lễ tân)
        if ($invoice->status === 'unpaid' && $invoice->details->isEmpty() && $invoice->appointment && $invoice->appointment->medicalRecord) {
            $medRec = $invoice->appointment->medicalRecord;
            $hasAnyChange = false;

            // 1. Đồng bộ các Dịch vụ Bác sĩ đã chỉ định
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

            // 2. Đồng bộ các Thuốc Bác sĩ đã kê
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
                $invoice->refresh()->load(['patient', 'details', 'payments', 'appointment.doctor.user', 'appointment.medicalRecord.prescription.details.medicine']);
            }
        }

        $settings = SystemSetting::pluck('setting_value', 'setting_key')->toArray();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $medicines = Medicine::orderBy('name')->get();
        return view('receptionist.invoices.show', compact('invoice', 'settings', 'services', 'medicines'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status !== 'unpaid') {
            return back()->with('error', 'Không thể chỉnh sửa hóa đơn đã thanh toán hoặc đã hủy.');
        }

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
        ], [
            'items.required' => 'Vui lòng chọn ít nhất 1 Dịch vụ khám hoặc Thuốc.',
            'items.min' => 'Vui lòng chọn ít nhất 1 Dịch vụ khám hoặc Thuốc.',
        ]);

        $vatRate = $this->getVatRate();

        $totalAmount = 0;
        foreach ($request->items as $item) {
            $totalAmount += ($item['price'] * $item['quantity']);
        }

        $discount = $request->discount ?? 0;
        $amountAfterDiscount = max(0, $totalAmount - $discount);
        $vatAmount = $amountAfterDiscount * ($vatRate / 100);
        $finalAmount = $amountAfterDiscount + $vatAmount;

        $invoice->update([
            'total_amount' => $totalAmount,
            'discount' => $discount,
            'vat_amount' => $vatAmount,
            'final_amount' => $finalAmount,
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

        return redirect()->route('receptionist.invoices.show', $invoice)->with('success', 'Đã cập nhật Dịch vụ & Thuốc và tự động tính lại số tiền cần thanh toán!');
    }

    public function resetFromDoctor(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Hóa đơn đã thanh toán, không thể hoàn tác.');
        }

        $appointment = $invoice->appointment;
        if (!$appointment || !$appointment->medicalRecord) {
            return back()->with('error', 'Không tìm thấy hồ sơ bệnh án của Bác sĩ cho lịch hẹn này.');
        }

        $medicalRecord = $appointment->medicalRecord;
        $items = [];

        // 1. Dịch vụ / thủ thuật khám
        if ($medicalRecord->details && $medicalRecord->details->count() > 0) {
            foreach ($medicalRecord->details as $detail) {
                if ($detail->service) {
                    $itemLabel = 'Dịch vụ: ' . $detail->service->name;
                    if (!empty($detail->note)) {
                        $itemLabel .= ' (' . $detail->note . ')';
                    }
                    $items[] = [
                        'item_name' => $itemLabel,
                        'unit_price' => floatval($detail->service->price),
                        'quantity' => max(1, intval($detail->quantity)),
                    ];
                }
            }
        }

        // 2. Thuốc kê đơn
        if ($medicalRecord->prescription && $medicalRecord->prescription->details) {
            foreach ($medicalRecord->prescription->details as $presDetail) {
                $medPrice = 0;
                $unitLabel = $presDetail->dosage ?: 'Đơn vị';
                if ($presDetail->medicine && floatval($presDetail->medicine->price) > 0) {
                    $medPrice = floatval($presDetail->medicine->price);
                    $unitLabel = $presDetail->medicine->unit ?: $unitLabel;
                } else {
                    $matchedMed = Medicine::where('name', $presDetail->medicine_name)->first();
                    $medPrice = ($matchedMed && floatval($matchedMed->price) > 0) ? floatval($matchedMed->price) : 15000;
                }
                $items[] = [
                    'item_name' => 'Thuốc: ' . $presDetail->medicine_name . ' (' . $unitLabel . ')',
                    'unit_price' => $medPrice,
                    'quantity' => max(1, intval($presDetail->quantity)),
                ];
            }
        }

        if (empty($items)) {
            $items[] = [
                'item_name' => 'Khám và tư vấn nha khoa tổng quát',
                'unit_price' => 100000,
                'quantity' => 1,
            ];
        }

        $totalAmount = 0;
        foreach ($items as $it) {
            $totalAmount += $it['unit_price'] * $it['quantity'];
        }

        $vatRate = $this->getVatRate();
        $vatAmount = $totalAmount * ($vatRate / 100);
        $finalAmount = $totalAmount + $vatAmount;

        $invoice->update([
            'total_amount' => $totalAmount,
            'discount' => 0,
            'vat_amount' => $vatAmount,
            'final_amount' => $finalAmount,
        ]);

        $invoice->details()->delete();
        foreach ($items as $it) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'item_name' => $it['item_name'],
                'unit_price' => $it['unit_price'],
                'quantity' => $it['quantity'],
                'total_price' => $it['unit_price'] * $it['quantity'],
            ]);
        }

        return redirect()->route('receptionist.invoices.show', $invoice)
            ->with('success', 'Đã khôi phục toàn bộ Dịch vụ & Thuốc gốc theo đúng đơn Bác sĩ đã kê!');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['patient', 'details', 'payments', 'appointment.doctor.user', 'appointment.medicalRecord.prescription.details.medicine']);
        $settings = SystemSetting::pluck('setting_value', 'setting_key')->toArray();
        return view('receptionist.invoices.print', compact('invoice', 'settings'));
    }

    public function pay(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'amount' => 'required|numeric|min:1'
        ]);

        $result = DB::transaction(function () use ($request, $invoice) {
            $lockedInvoice = Invoice::where('id', $invoice->id)->lockForUpdate()->firstOrFail();

            if ($lockedInvoice->status !== 'unpaid') {
                return [
                    'error' => $lockedInvoice->status === 'paid'
                        ? 'Hóa đơn này đã được thanh toán đầy đủ trước đó.'
                        : 'Không thể thanh toán hóa đơn đã hủy.'
                ];
            }

            Payment::create([
                'invoice_id' => $lockedInvoice->id,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'status' => 'completed'
            ]);

            $totalPaid = floatval($lockedInvoice->payments()->where('status', 'completed')->sum('amount'));
            $stockMsg = '';

            if ($totalPaid >= floatval($lockedInvoice->final_amount)) {
                $lockedInvoice->update(['status' => 'paid']);
                $deducted = $lockedInvoice->deductMedicineStock();
                if ($deducted > 0) {
                    $stockMsg = " Đã tự động trừ tồn kho {$deducted} mặt hàng thuốc.";
                }
            }

            return ['success' => 'Thanh toán thành công.' . $stockMsg];
        });

        if (isset($result['error'])) {
            return redirect()->route('receptionist.invoices.show', $invoice)->with('error', $result['error']);
        }

        return redirect()->route('receptionist.invoices.show', $invoice)->with('success', $result['success']);
    }
}
