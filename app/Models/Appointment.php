<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Closure;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function withDoctorScheduleLock(int|array|null $doctorIds, Closure $callback): mixed
    {
        return DB::transaction(function () use ($doctorIds, $callback) {
            $doctorIds = array_values(array_unique(array_filter(array_map(
                'intval',
                is_array($doctorIds) ? $doctorIds : [$doctorIds]
            ))));
            sort($doctorIds);

            foreach ($doctorIds as $doctorId) {
                \App\Models\Doctor::whereKey($doctorId)->lockForUpdate()->firstOrFail();
            }

            return $callback();
        });
    }

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

    /**
     * Tính thời lượng (phút) của 1 lịch hẹn dựa theo dịch vụ (mặc định 30 phút)
     */
    public static function resolveDurationMinutes(?int $serviceId): int
    {
        if ($serviceId) {
            $service = Service::find($serviceId);
            if ($service && intval($service->duration_minutes) > 0) {
                return max(15, intval($service->duration_minutes));
            }
        }
        return 30;
    }

    /**
     * Tìm lịch hẹn bị chồng lấn khung giờ [start, end) của cùng 1 bác sĩ theo thời lượng thực tế của dịch vụ
     */
    public static function findDoctorConflict(
        int $doctorId,
        \Carbon\Carbon $startTime,
        ?int $serviceId = null,
        ?int $ignoreAppointmentId = null
    ): ?array {
        $newDuration = self::resolveDurationMinutes($serviceId);
        $newEnd = $startTime->copy()->addMinutes($newDuration);

        $query = self::with('service')
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_time', $startTime->toDateString())
            ->whereIn('status', ['pending', 'confirmed', 'waiting', 'in_progress']);

        if ($ignoreAppointmentId) {
            $query->where('id', '!=', $ignoreAppointmentId);
        }

        $existingAppointments = $query->orderBy('appointment_time')->get();

        foreach ($existingAppointments as $existing) {
            $exStart = \Carbon\Carbon::parse($existing->appointment_time);
            $rawDur = intval($existing->service->duration_minutes ?? 0);
            $exDuration = $rawDur > 0 ? max(15, $rawDur) : 30;
            $exEnd = $exStart->copy()->addMinutes($exDuration);

            if ($startTime->lt($exEnd) && $exStart->lt($newEnd)) {
                return [
                    'appointment' => $existing,
                    'start' => $exStart->format('H:i'),
                    'end' => $exEnd->format('H:i'),
                    'duration' => $exDuration,
                ];
            }
        }

        return null;
    }

    /**
     * Trả về danh sách các khung giờ bác sĩ đã có lịch trong ngày
     */
    public static function getDoctorBusySlots(int $doctorId, string $date): array
    {
        $appointments = self::with('service')
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_time', $date)
            ->whereIn('status', ['pending', 'confirmed', 'waiting', 'in_progress'])
            ->orderBy('appointment_time')
            ->get();

        $slots = [];
        foreach ($appointments as $apt) {
            $start = \Carbon\Carbon::parse($apt->appointment_time);
            $rawDur = intval($apt->service->duration_minutes ?? 0);
            $duration = $rawDur > 0 ? max(15, $rawDur) : 30;
            $end = $start->copy()->addMinutes($duration);

            $slots[] = [
                'start' => $start->format('H:i'),
                'end' => $end->format('H:i'),
                'start_minutes' => $start->hour * 60 + $start->minute,
                'end_minutes' => $end->hour * 60 + $end->minute,
                'duration' => $duration,
            ];
        }

        return $slots;
    }
}
