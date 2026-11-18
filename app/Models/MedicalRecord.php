<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
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

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function details()
    {
        return $this->hasMany(MedicalRecordDetail::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function materialUsages()
    {
        return $this->hasMany(MaterialUsage::class);
    }
}
