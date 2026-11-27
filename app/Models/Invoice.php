<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Tự động trừ số lượng tồn kho thuốc khi hóa đơn được thanh toán hoàn tất
     * (Bỏ qua những thuốc đã được trừ kho trực tiếp lúc Bác sĩ kê đơn có gắn medicine_id)
     */
    public function deductMedicineStock(): int
    {
        $this->loadMissing(['details', 'appointment.medicalRecord.prescription.details']);

        $alreadyDeductedIds = [];
        $prescription = $this->appointment->medicalRecord->prescription ?? null;
        if ($prescription && $prescription->details) {
            foreach ($prescription->details as $pDetail) {
                if (!empty($pDetail->medicine_id)) {
                    $alreadyDeductedIds[] = (int) $pDetail->medicine_id;
                }
            }
        }

        $medicines = Medicine::all();
        $deductedCount = 0;

        foreach ($this->details as $detail) {
            $itemLower = mb_strtolower(trim($detail->item_name));
            if (!str_contains($itemLower, 'thuốc') && !str_contains($itemLower, 'gói thuốc')) {
                continue;
            }
            foreach ($medicines as $med) {
                $medLower = mb_strtolower(trim($med->name));
                if ($medLower !== '' && str_contains($itemLower, $medLower)) {
                    if (!in_array((int) $med->id, $alreadyDeductedIds, true)) {
                        $qty = max(1, intval($detail->quantity));
                        $med->stock_quantity = max(0, intval($med->stock_quantity) - $qty);
                        $med->save();
                        $deductedCount++;
                    }
                    break;
                }
            }
        }

        return $deductedCount;
    }
}
