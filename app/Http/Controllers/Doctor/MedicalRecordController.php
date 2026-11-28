<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordDetail;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\SystemSetting;

class MedicalRecordController extends Controller
{
    protected function ownsMedicalRecord(MedicalRecord $record): bool
    {
        $doctorId = auth()->user()->doctor->id ?? null;
        if (!$doctorId) {
            return false;
        }

        if ((int) $record->doctor_id === (int) $doctorId) {
            return true;
        }

        $record->loadMissing('appointment');
        return !$record->doctor_id
            && (int) ($record->appointment?->doctor_id ?? 0) === (int) $doctorId;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'symptoms' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'notes' => 'nullable|string',
            'note' => 'nullable|string',
            'teeth_data' => 'nullable|string',
            'allergy_history' => 'nullable|string|max:1000',
            'medical_history' => 'nullable|string|max:1000',
        ]);

        $record = MedicalRecord::with('patient')->findOrFail($id);

        if (!$this->ownsMedicalRecord($record)) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Bạn không có quyền chỉnh sửa bệnh án này.'], 403);
            }
            return back()->with('error', 'Bạn không có quyền chỉnh sửa bệnh án này.');
        }

        if ($record->patient && ($request->has('allergy_history') || $request->has('medical_history'))) {
            $record->patient->update([
                'allergy_history' => $request->input('allergy_history', $record->patient->allergy_history),
                'medical_history' => $request->input('medical_history', $record->patient->medical_history),
            ]);
        }

        if ($request->boolean('update_patient_history_only')) {
            return back()->with('success', 'Đã cập nhật Tiền sử Dị ứng & Bệnh lý nền của bệnh nhân!');
        }
        
        // Cập nhật bệnh án và sơ đồ răng
        $record->update([
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
            'note' => $request->notes ?? $request->note ?? $record->note,
            'teeth_data' => $request->teeth_data,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Lưu bệnh án & sơ đồ răng thành công!']);
        }

        return back()->with('success', 'Đã lưu thông tin bệnh án và sơ đồ răng!');
    }

    /**
     * Bác sĩ chỉ định thêm Dịch vụ / Thủ thuật phát sinh ngay trong ca khám
     */
    public function storeServiceDetail(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1|max:50',
            'note' => 'nullable|string|max:255',
        ]);

        $record = MedicalRecord::findOrFail($id);

        if (!$this->ownsMedicalRecord($record)) {
            return back()->with('error', 'Bạn không có quyền chỉ định dịch vụ cho bệnh án này.');
        }

        MedicalRecordDetail::create([
            'medical_record_id' => $record->id,
            'service_id' => $request->service_id,
            'quantity' => $request->quantity,
            'note' => $request->note,
        ]);

        $this->syncUnpaidInvoiceServices($record);

        return back()->with('success', 'Đã thêm dịch vụ / thủ thuật chỉ định vào hồ sơ khám và đồng bộ chi phí!');
    }

    /**
     * Xóa Dịch vụ / Thủ thuật phát sinh khỏi ca khám
     */
    public function destroyServiceDetail($detailId)
    {
        $detail = MedicalRecordDetail::findOrFail($detailId);
        $record = MedicalRecord::find($detail->medical_record_id);

        if ($record && !$this->ownsMedicalRecord($record)) {
            return back()->with('error', 'Bạn không có quyền xóa dịch vụ khỏi bệnh án này.');
        }

        $detail->delete();

        if ($record) {
            $this->syncUnpaidInvoiceServices($record);
        }

        return back()->with('success', 'Đã xóa dịch vụ / thủ thuật khỏi hồ sơ khám!');
    }

    /**
     * Đồng bộ các Dịch vụ / Thủ thuật phát sinh sang Hóa đơn chưa thanh toán (nếu có)
     */
    protected function syncUnpaidInvoiceServices(MedicalRecord $record): void
    {
        $record->loadMissing(['details.service']);
        if (!$record->appointment_id) {
            return;
        }

        $invoice = Invoice::where('appointment_id', $record->appointment_id)
            ->where('status', 'unpaid')
            ->first();

        if (!$invoice) {
            return;
        }

        $invoice->details()->where('item_name', 'like', 'Dịch vụ/Thủ thuật:%')->delete();

        foreach ($record->details as $detail) {
            if ($detail->service) {
                $itemLabel = 'Dịch vụ/Thủ thuật: ' . $detail->service->name;
                if (!empty($detail->note)) {
                    $itemLabel .= ' (' . $detail->note . ')';
                }
                $qty = max(1, intval($detail->quantity));
                $price = floatval($detail->service->price);

                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $detail->service->id,
                    'item_name' => $itemLabel,
                    'unit_price' => $price,
                    'quantity' => $qty,
                    'total_price' => $price * $qty,
                ]);
            }
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
}
