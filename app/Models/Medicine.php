<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'category',
        'unit',
        'import_price',
        'price',
        'stock_quantity',
        'expiry_date',
        'description',
    ];

    public function getMedicineCodeAttribute(): string
    {
        return 'TH' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }
}
