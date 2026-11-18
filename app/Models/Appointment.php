<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function getReasonAttribute(): ?string
    {
        return $this->attributes['note'] ?? $this->attributes['reason'] ?? null;
    }

    /**
     * Kiểm tra lịch hẹn đã đến khung giờ hẹn chưa (từ 30 phút trước giờ hẹn đến 15 phút sau giờ hẹn)
     */
    public function isDueNow(): bool
    {
        if (!in_array($this->status, ['pending', 'confirmed'])) {
            return false;
        }
        $aptTime = \Carbon\Carbon::parse($this->appointment_time);
        $now = now();
        return $now->between($aptTime->copy()->subMinutes(30), $aptTime->copy()->addMinutes(15));
    }

    /**
     * Kiểm tra lịch hẹn đã quá thời gian hẹn chưa (quá 15 phút sau giờ hẹn mà chưa check-in)
     */
    public function isOverdue(): bool
    {
        if (!in_array($this->status, ['pending', 'confirmed'])) {
            return false;
        }
        $aptTime = \Carbon\Carbon::parse($this->appointment_time);
        return now()->gt($aptTime->copy()->addMinutes(15));
    }

    /**
     * Trả về trạng thái thời gian: 'overdue' | 'due' | 'upcoming' | 'normal'
     */
    public function getTimeStatusAttribute(): string
    {
        if ($this->isOverdue()) {
            return 'overdue';
        }
        if ($this->isDueNow()) {
            return 'due';
        }
        if (in_array($this->status, ['pending', 'confirmed'])) {
            return 'upcoming';
        }
        return 'normal';
    }
}
