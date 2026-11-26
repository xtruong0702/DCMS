<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\Medicine;
use App\Models\Supply;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = auth()->user()->doctor->id ?? 0;
        $status = $request->input('status');
        $date = $request->input('date');

        $query = Appointment::with(['patient', 'service', 'medicalRecord'])
            ->where(function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId)
                  ->orWhereNull('doctor_id');
            });

        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['in_progress', 'waiting', 'confirmed', 'completed', 'pending']);
        }

        if ($date) {
            $query->whereDate('appointment_time', $date);
        }

        $consultations = $query->orderByRaw("CASE status WHEN 'in_progress' THEN 1 WHEN 'waiting' THEN 2 WHEN 'confirmed' THEN 3 WHEN 'pending' THEN 4 WHEN 'completed' THEN 5 ELSE 6 END")
            ->orderBy('appointment_time', 'desc')
            ->paginate(15);

        return view('doctor.consultations.index', compact('consultations', 'status', 'date'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        // Ensure this doctor owns the appointment (or assign this doctor if unassigned)
        $doctorId = auth()->user()->doctor->id ?? null;
        if ($appointment->doctor_id && $appointment->doctor_id !== $doctorId) {
            return back()->with('error', 'Bạn không có quyền thao tác trên cuộc hẹn này.');
        }

        $updateData = [];
        if (!$appointment->doctor_id && $doctorId) {
            $updateData['doctor_id'] = $doctorId;
        }
        if ($request->has('status')) {
            $updateData['status'] = $request->status;
        }

        if (!empty($updateData)) {
            $appointment->update($updateData);
        }

        if ($request->status === 'in_progress') {
            return redirect()->route('doctor.consultations.show', $appointment->id)->with('success', 'Đã gọi bệnh nhân vào phòng khám.');
        }

        if ($request->status === 'confirmed') {
            return redirect()->back()->with('success', 'Bác sĩ đã xác nhận lịch khám! Thông báo xác nhận đã được cập nhật cho bệnh nhân.');
        }

        return redirect()->route('doctor.dashboard')->with('success', 'Đã cập nhật trạng thái ca khám.');
    }

    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'service'])->findOrFail($id);
        
        $doctorId = auth()->user()->doctor->id ?? null;
        if ($appointment->doctor_id && $appointment->doctor_id !== $doctorId) {
            return redirect()->route('doctor.dashboard')->with('error', 'Bạn không có quyền xem cuộc hẹn này.');
        }

        if (!$appointment->doctor_id && $doctorId) {
            $appointment->update(['doctor_id' => $doctorId]);
        }

        // Get or create medical record for this appointment
        $medicalRecord = MedicalRecord::with(['materialUsages.supply', 'details.service'])->firstOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
            ]
        );

        // Get or create prescription linked via medical_record_id
        $prescription = Prescription::with('details.medicine')->firstOrCreate(
            ['medical_record_id' => $medicalRecord->id]
        );

        // Đảm bảo kho thuốc luôn có danh mục thuốc nha khoa chuẩn kèm giá bán
        if (Medicine::count() === 0) {
            $defaultMedicines = [
                ['name' => 'Gói thuốc kháng viêm - giảm đau cơ bản (3 ngày)', 'category' => 'Gói đơn thuốc', 'unit' => 'Liệu trình', 'import_price' => 60000, 'price' => 120000, 'stock_quantity' => 100],
                ['name' => 'Gói thuốc sau nhổ răng khôn / Tiểu phẫu (5 ngày)', 'category' => 'Gói đơn thuốc', 'unit' => 'Liệu trình', 'import_price' => 130000, 'price' => 250000, 'stock_quantity' => 100],
                ['name' => 'Kháng sinh Amoxicillin + Acid Clavulanic 625mg', 'category' => 'Kháng sinh', 'unit' => 'Viên', 'import_price' => 5000, 'price' => 8000, 'stock_quantity' => 500],
                ['name' => 'Thuốc giảm đau - kháng viêm Ibuprofen 400mg', 'category' => 'Giảm đau', 'unit' => 'Viên', 'import_price' => 2000, 'price' => 4000, 'stock_quantity' => 500],
                ['name' => 'Thuốc chống phù nề Alpha Choay', 'category' => 'Chống viêm', 'unit' => 'Viên', 'import_price' => 2500, 'price' => 4000, 'stock_quantity' => 500],
                ['name' => 'Nước súc miệng sát khuẩn Chlorhexidine 0.12%', 'category' => 'Chăm sóc răng', 'unit' => 'Chai 250ml', 'import_price' => 55000, 'price' => 85000, 'stock_quantity' => 90],
                ['name' => 'Gel bôi nhiệt miệng & viêm lợi Kamistad-Gel N', 'category' => 'Thuốc bôi', 'unit' => 'Tuýp 10g', 'import_price' => 38000, 'price' => 55000, 'stock_quantity' => 70],
            ];
            foreach ($defaultMedicines as $med) {
                Medicine::firstOrCreate(['name' => $med['name']], $med);
            }
        }

        $medicines = Medicine::where('stock_quantity', '>', 0)->get();
        $supplies = Supply::where('stock_quantity', '>', 0)->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('doctor.consultations.show', compact('appointment', 'medicalRecord', 'prescription', 'medicines', 'supplies', 'services'));
    }

    // Hoàn thành ca khám & Tự động tạo hóa đơn chuyển sang Thu ngân
    public function complete($id)
    {
        $appointment = Appointment::with(['patient', 'service'])->findOrFail($id);

        DB::transaction(function () use ($appointment) {
            $appointment->update(['status' => 'completed']);

            // Kiểm tra nếu chưa có hóa đơn cho ca khám này thì tự động khởi tạo
            $existingInvoice = Invoice::where('appointment_id', $appointment->id)->first();
            if (!$existingInvoice) {
                $medicalRecord = MedicalRecord::with(['details.service', 'prescription.details.medicine'])
                    ->where('appointment_id', $appointment->id)
                    ->first();

                $items = [];

                // 1. Dịch vụ khám chính của lịch hẹn
                if ($appointment->service) {
                    $items[] = [
                        'item_name' => $appointment->service->name,
                        'unit_price' => floatval($appointment->service->price),
                        'quantity' => 1,
                    ];
                }

                // 2. Các dịch vụ/thủ thuật phát sinh trong bệnh án (nếu có)
                if ($medicalRecord && $medicalRecord->details) {
                    foreach ($medicalRecord->details as $detail) {
                        if ($detail->service) {
                            $itemLabel = 'Dịch vụ/Thủ thuật: ' . $detail->service->name;
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

                // 3. Thuốc kê đơn (tự động lấy giá thuốc từ kho hoặc áp giá chuẩn nếu kê ngoài)
                if ($medicalRecord && $medicalRecord->prescription && $medicalRecord->prescription->details) {
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

                // Nếu chưa chọn dịch vụ nào, thêm phí khám tổng quát mặc định
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

                $vatSetting = SystemSetting::where('setting_key', 'vat_percentage')->first();
                $vatRate = ($vatSetting && $vatSetting->setting_value !== '') ? floatval($vatSetting->setting_value) : 10;
                if ($vatRate <= 0) {
                    $vatRate = 10;
                }
                $vatAmount = $totalAmount * ($vatRate / 100);
                $finalAmount = $totalAmount + $vatAmount;

                $invoice = Invoice::create([
                    'invoice_code' => 'HD' . date('YmdHis') . rand(10, 99),
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointment->id,
                    'total_amount' => $totalAmount,
                    'discount' => 0,
                    'vat_amount' => $vatAmount,
                    'final_amount' => $finalAmount,
                    'status' => 'unpaid',
                ]);

                foreach ($items as $it) {
                    InvoiceDetail::create([
                        'invoice_id' => $invoice->id,
                        'item_name' => $it['item_name'],
                        'unit_price' => $it['unit_price'],
                        'quantity' => $it['quantity'],
                        'total_price' => $it['unit_price'] * $it['quantity'],
                    ]);
                }
            }
        });

        return redirect()->route('doctor.dashboard')->with('success', 'Đã hoàn thành ca khám và tự động chuyển hóa đơn sang bộ phận Thu ngân!');
    }
}
