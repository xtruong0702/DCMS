<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
