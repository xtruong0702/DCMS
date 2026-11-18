<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'import_price',
        'stock_quantity',
        'minimum_stock',
        'expiry_date',
        'description',
    ];
}
