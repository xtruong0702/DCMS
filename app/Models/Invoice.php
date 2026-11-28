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
        $this->loadMissing(['details.medicine', 'appointment.medicalRecord.prescription.details']);

        $alreadyDeductedIds = [];
        $prescription = $this->appointment->medicalRecord->prescription ?? null;
        if ($prescription && $prescription->details) {
            foreach ($prescription->details as $pDetail) {
                if (!empty($pDetail->medicine_id)) {
                    $alreadyDeductedIds[] = (int) $pDetail->medicine_id;
                }
            }
        }

        $quantities = [];
        foreach ($this->details as $detail) {
            $medicineId = (int) $detail->medicine_id;
            if (!$medicineId || in_array($medicineId, $alreadyDeductedIds, true)) {
                continue;
            }
            $quantities[$medicineId] = ($quantities[$medicineId] ?? 0) + max(1, (int) $detail->quantity);
        }

        $deductedCount = 0;
        foreach ($quantities as $medicineId => $quantity) {
            $medicine = Medicine::whereKey($medicineId)->lockForUpdate()->first();
            if (!$medicine) {
                continue;
            }
            if ((int) $medicine->stock_quantity < $quantity) {
                throw new \RuntimeException("Không đủ tồn kho thuốc [{$medicine->name}] để hoàn tất hóa đơn.");
            }
            $medicine->decrement('stock_quantity', $quantity);
            $deductedCount++;
        }

        return $deductedCount;
    }
}
