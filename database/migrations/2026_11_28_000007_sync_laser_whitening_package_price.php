<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $basePrice = DB::table('services')->where('service_code', 'SV005')->value('price');

        DB::table('services')->where('service_code', 'PKG-WHITENING-LASER')->update([
            'price' => $basePrice ?? 2500000,
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('services')->where('service_code', 'PKG-WHITENING-LASER')->update([
            'price' => 2500000,
            'updated_at' => now(),
        ]);
    }
};
