<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialUsage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
