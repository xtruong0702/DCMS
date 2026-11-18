<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cập nhật bảng medical_records: Thêm treatment_plan và teeth_data
        Schema::table('medical_records', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_records', 'treatment_plan')) {
                $table->text('treatment_plan')->nullable()->after('diagnosis');
            }
            if (!Schema::hasColumn('medical_records', 'teeth_data')) {
                $table->longText('teeth_data')->nullable()->after('treatment_plan');
            }
        });

        // 2. Tạo bảng material_usages (Ghi nhận vật tư y tế tiêu hao trong ca khám)
        if (!Schema::hasTable('material_usages')) {
            Schema::create('material_usages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
                $table->foreignId('medical_record_id')->nullable()->constrained('medical_records')->cascadeOnDelete();
                $table->foreignId('supply_id')->constrained('supplies')->cascadeOnDelete();
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
                $table->integer('quantity')->default(1);
                $table->text('note')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('material_usages');

        Schema::table('medical_records', function (Blueprint $table) {
            if (Schema::hasColumn('medical_records', 'teeth_data')) {
                $table->dropColumn('teeth_data');
            }
            if (Schema::hasColumn('medical_records', 'treatment_plan')) {
                $table->dropColumn('treatment_plan');
            }
        });
    }
};
