<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $durations = [
            'PKG-IMPLANT-%' => 90,
            'PKG-ORTHO-%' => 60,
            'PKG-WHITENING-%' => 45,
            'PKG-WHITENING-LASER%' => 60,
            'PKG-WISDOM-%' => 45,
            'PKG-ROOT-%' => 60,
            'PKG-CROWN-%' => 60,
        ];

        foreach ($durations as $pattern => $minutes) {
            DB::table('services')->where('service_code', 'like', $pattern)->update([
                'duration_minutes' => $minutes,
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('services')->whereIn('service_code', [
            'PKG-IMPLANT-OSSTEM', 'PKG-IMPLANT-DENTIUM', 'PKG-IMPLANT-TEKKA', 'PKG-IMPLANT-STRAUMANN', 'PKG-IMPLANT-SLACTIVE',
            'PKG-ORTHO-METAL', 'PKG-ORTHO-SELF-LIGATING', 'PKG-ORTHO-CERAMIC', 'PKG-ORTHO-INVISALIGN-LITE', 'PKG-ORTHO-INVISALIGN-COMPREHENSIVE',
            'PKG-WHITENING-TRAY', 'PKG-WHITENING-LASER', 'PKG-WHITENING-COMBO',
            'PKG-WISDOM-STRAIGHT-UPPER', 'PKG-WISDOM-STRAIGHT-LOWER', 'PKG-WISDOM-PIEZOTOME', 'PKG-WISDOM-COMPLEX', 'PKG-WISDOM-NERVE-RISK', 'PKG-WISDOM-PRF',
            'PKG-ROOT-ANTERIOR', 'PKG-ROOT-PREMOLAR', 'PKG-ROOT-MOLAR', 'PKG-ROOT-REPEAT',
            'PKG-CROWN-TITANIUM', 'PKG-CROWN-ZIRCONIA', 'PKG-CROWN-CERCON', 'PKG-CROWN-LAVA', 'PKG-CROWN-VENEER-EMAX', 'PKG-CROWN-ORODENT',
        ])->update(['duration_minutes' => 30, 'updated_at' => now()]);
    }
};
