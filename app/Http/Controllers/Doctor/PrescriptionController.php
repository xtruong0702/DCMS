<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\Medicine;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    protected function ownsPrescription(?Prescription $prescription): bool
    {
        $doctorId = auth()->user()->doctor->id ?? null;
        if (!$doctorId || !$prescription) {
            return false;
        }
        $prescription->loadMissing('medicalRecord.appointment');
        $record = $prescription->medicalRecord;
        return $record && (
            (int) $record->doctor_id === (int) $doctorId
            || (!$record->doctor_id && (int) ($record->appointment?->doctor_id ?? 0) === (int) $doctorId)
        );
    }

    public function index()
    {
        $doctorId = auth()->user()->doctor->id ?? 0;
        $prescriptions = Prescription::with(['medicalRecord.patient', 'medicalRecord.appointment', 'details'])
            ->whereHas('medicalRecord', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->latest()
            ->paginate(15);

        return view('doctor.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Đồng bộ lại Hóa đơn (nếu đã tạo và chưa thanh toán) khi Bác sĩ thêm/xóa thuốc trong đơn
     */
    protected function syncUnpaidInvoice(Prescription $prescription): void
    {
        $prescription->loadMissing(['medicalRecord.appointment.service', 'medicalRecord.details.service', 'details.medicine']);
        $medicalRecord = $prescription->medicalRecord;
        if (!$medicalRecord || !$medicalRecord->appointment_id) {
            return;
        }

        $invoice = Invoice::where('appointment_id', $medicalRecord->appointment_id)
            ->where('status', 'unpaid')
            ->first();

        if (!$invoice) {
            return;
        }

        // Xóa các dòng thuốc cũ trên hóa đơn và đồng bộ lại từ đơn thuốc hiện tại
        $invoice->details()->where('item_name', 'like', 'Thuốc:%')->delete();

        foreach ($prescription->details as $presDetail) {
            $medPrice = 0;
            $unitLabel = $presDetail->dosage ?: 'Đơn vị';
            if ($presDetail->medicine && floatval($presDetail->medicine->price) > 0) {
                $medPrice = floatval($presDetail->medicine->price);
                $unitLabel = $presDetail->medicine->unit ?: $unitLabel;
            } else {
                $matchedMed = Medicine::where('name', $presDetail->medicine_name)->first();
                $medPrice = ($matchedMed && floatval($matchedMed->price) > 0) ? floatval($matchedMed->price) : 15000;
            }

            $qty = max(1, intval($presDetail->quantity));
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'medicine_id' => $presDetail->medicine_id,
                'item_name' => 'Thuốc: ' . $presDetail->medicine_name . ' (' . $unitLabel . ')',
                'unit_price' => $medPrice,
                'quantity' => $qty,
                'total_price' => $medPrice * $qty,
            ]);
        }

        $totalAmount = $invoice->details()->sum('total_price');
        $discount = floatval($invoice->discount);
        $taxable = max(0, $totalAmount - $discount);

        $vatSetting = SystemSetting::where('setting_key', 'vat_percentage')->first();
        $vatRate = ($vatSetting && $vatSetting->setting_value !== '' && is_numeric($vatSetting->setting_value))
            ? max(0, floatval($vatSetting->setting_value))
            : 10;
        $vatAmount = $taxable * ($vatRate / 100);
        $finalAmount = $taxable + $vatAmount;

        $invoice->update([
            'total_amount' => $totalAmount,
            'vat_amount' => $vatAmount,
            'final_amount' => $finalAmount,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'medicine_id' => 'nullable|exists:medicines,id',
            'medicine_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'dosage' => 'nullable|string|max:255',
            'usage_morning' => 'nullable|string|max:255',
            'usage_noon' => 'nullable|string|max:255',
            'usage_evening' => 'nullable|string|max:255',
            'usage_night' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
        ]);

        $prescription = Prescription::with('medicalRecord.patient')->findOrFail($request->prescription_id);
        if (!$this->ownsPrescription($prescription)) {
            return back()->with('error', 'Bạn không có quyền kê đơn thuốc cho hồ sơ này.');
        }

        try {
            DB::beginTransaction();

            $medicineName = $request->medicine_name;
            $medicine = null;

            if ($request->medicine_id) {
                $medicine = Medicine::where('id', $request->medicine_id)->lockForUpdate()->firstOrFail();
            } else {
                $medicine = Medicine::where('name', trim($medicineName))->lockForUpdate()->first();
            }

            if ($medicine) {
                if ($medicine->stock_quantity < $request->quantity) {
                    DB::rollBack();
                    return back()->with('error', 'Thuốc [' . $medicine->name . '] không đủ tồn kho! Tồn hiện tại: ' . $medicine->stock_quantity);
                }

                $medicineName = $medicine->name;
            }

            // Kiểm tra cảnh báo Dị ứng thuốc tự động từ hồ sơ bệnh nhân
            $patient = $prescription->medicalRecord->patient ?? null;
            if ($patient && !empty(trim($patient->allergy_history)) && !$request->boolean('force_allergy_override')) {
                $allergyRaw = mb_strtolower($patient->allergy_history);
                $medLower = mb_strtolower($medicineName);
                $tokens = preg_split('/[,;\/\-\n]+/', $allergyRaw);
                $matchedAllergy = null;

                foreach ($tokens as $token) {
                    $cleanToken = trim($token);
                    if (mb_strlen($cleanToken) >= 3 && (mb_strpos($medLower, $cleanToken) !== false || mb_strpos($cleanToken, $medLower) !== false)) {
                        $matchedAllergy = $cleanToken;
                        break;
                    }
                }

                if ($matchedAllergy) {
                    DB::rollBack();
                    return back()->with('error', '⚠️ CẢNH BÁO DỊ ỨNG THUỐC: Bệnh nhân có tiền sử dị ứng [' . $patient->allergy_history . '] trùng khớp với [' . $medicineName . ']! Nếu Bác sĩ đã cân nhắc lâm sàng và vẫn chỉ định, vui lòng tích chọn "Xác nhận vượt cảnh báo dị ứng".');
                }
            }

            if ($medicine) {
                $medicine->decrement('stock_quantity', $request->quantity);
            }

            PrescriptionDetail::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $medicine?->id,
                'medicine_name' => $medicineName,
                'quantity' => $request->quantity,
                'dosage' => $request->dosage,
                'usage_morning' => $request->usage_morning,
                'usage_noon' => $request->usage_noon,
                'usage_evening' => $request->usage_evening,
                'usage_night' => $request->usage_night,
                'instructions' => $request->instructions,
            ]);

            $prescription->refresh();
            $this->syncUnpaidInvoice($prescription);

            DB::commit();

            return redirect()->back()->with('success', 'Đã thêm thuốc vào đơn và đồng bộ sang hóa đơn!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $detail = PrescriptionDetail::with('prescription.medicalRecord')->findOrFail($id);
            $prescription = $detail->prescription;

            if (!$this->ownsPrescription($prescription)) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Bạn không có quyền xóa thuốc khỏi đơn này.');
            }

            if ($detail->medicine_id) {
                $medicine = Medicine::where('id', $detail->medicine_id)->lockForUpdate()->first();
                if ($medicine) {
                    $medicine->increment('stock_quantity', $detail->quantity);
                }
            }

            $detail->delete();

            if ($prescription) {
                $prescription->refresh();
                $this->syncUnpaidInvoice($prescription);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Đã xóa thuốc khỏi đơn, hoàn kho và cập nhật lại hóa đơn!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'note' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);

        $prescription = Prescription::with('medicalRecord')->findOrFail($id);
        if (!$this->ownsPrescription($prescription)) {
            return redirect()->back()->with('error', 'Bạn không có quyền cập nhật đơn thuốc này.');
        }

        $prescription->update($request->only(['note', 'follow_up_date']));

        return redirect()->back()->with('success', 'Đã lưu thông tin chung của đơn thuốc!');
    }
}
