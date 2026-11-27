<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Trả về URL ảnh chân dung đồng bộ, đúng giới tính và danh tính cho từng Bác sĩ
     */
    public function getAvatarUrlAttribute(): string
    {
        $name = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($this->user->name ?? ''));
        $email = strtolower($this->user->email ?? '');

        if (str_contains($name, 'duc trong') || str_contains($email, 'trong')) {
            return asset('images/doctors/doc-vu-duc-trong.jpg') . '?v=3';
        }
        if (str_contains($name, 'hoang nam') || str_contains($email, 'nam.le')) {
            return asset('images/doctors/doc-le-hoang-nam.jpg') . '?v=3';
        }
        if (str_contains($name, 'thu ha') || str_contains($email, 'ha.nguyen')) {
            return asset('images/doctors/doc-nguyen-thu-ha.jpg') . '?v=3';
        }
        if (str_contains($name, 'phuong uyen') || str_contains($email, 'uyen.')) {
            return asset('images/doctors/doc-mai-phuong-uyen.jpg') . '?v=3';
        }
        if (str_contains($name, 'tran van') || str_contains($email, 'bacsi@')) {
            return asset('images/doctors/doc-tran-van-a.jpg') . '?v=3';
        }

        // Fallback theo giới tính đoán từ tên hoặc xoay vòng ảnh local
        $pool = [
            asset('images/doctors/doc-tran-van-a.jpg') . '?v=3',
            asset('images/doctors/doc-le-hoang-nam.jpg') . '?v=3',
            asset('images/doctors/doc-nguyen-thu-ha.jpg') . '?v=3',
            asset('images/doctors/doc-mai-phuong-uyen.jpg') . '?v=3',
            asset('images/doctors/doc-vu-duc-trong.jpg') . '?v=3',
        ];

        return $pool[(int) ($this->id ?? 0) % count($pool)];
    }
}
