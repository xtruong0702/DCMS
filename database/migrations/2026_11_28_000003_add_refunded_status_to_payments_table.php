<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE `payments` MODIFY COLUMN `status` ENUM('pending', 'completed', 'failed', 'refunded') NOT NULL DEFAULT 'completed'");
        } else {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('status', 30)->default('completed')->change();
            });
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("UPDATE `payments` SET `status` = 'failed' WHERE `status` = 'refunded'");
            DB::statement("ALTER TABLE `payments` MODIFY COLUMN `status` ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'completed'");
        }
    }
};
