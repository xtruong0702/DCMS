<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. users table is already created, but we need to add role_id and status
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('cccd')->nullable()->unique();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(true);
        });

        // 2. doctors
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('specialty')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. receptionists
        Schema::create('receptionists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // 4. patients
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_code')->unique();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('job')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('allergy_history')->nullable();
            $table->text('medical_history')->nullable();
            $table->string('contact_person')->nullable();
            $table->timestamps();
        });

        // 5. services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_code')->unique();
            $table->string('name');
            $table->string('type')->nullable(); // e.g., diagnostic, treatment
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('duration_minutes')->default(30);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. appointments
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->dateTime('appointment_time');
            $table->enum('status', ['pending', 'confirmed', 'waiting', 'in_progress', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // 7. medical_records
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->text('symptoms')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // 8. medical_record_details
        Schema::create('medical_record_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained('medical_records')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // 9. prescriptions
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained('medical_records')->cascadeOnDelete();
            $table->text('note')->nullable();
            $table->dateTime('follow_up_date')->nullable();
            $table->timestamps();
        });

        // 10. prescription_details
        Schema::create('prescription_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->cascadeOnDelete();
            $table->string('medicine_name');
            $table->string('dosage')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('usage_morning')->nullable();
            $table->string('usage_noon')->nullable();
            $table->string('usage_evening')->nullable();
            $table->string('usage_night')->nullable();
            $table->text('instructions')->nullable(); // before/after meal etc.
            $table->timestamps();
        });

        // 11. invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('vat_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');
            $table->timestamps();
        });

        // 12. invoice_details
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->string('item_name'); // e.g., Service Name or Medicine
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 15, 2)->default(0);
            $table->timestamps();
        });

        // 13. payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->string('payment_method'); // cash, bank_transfer, pos, qr
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            $table->timestamps();
        });

        // 14. system_settings
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key')->unique();
            $table->text('setting_value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoice_details');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('prescription_details');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('medical_record_details');
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('services');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('receptionists');
        Schema::dropIfExists('doctors');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'phone', 'cccd', 'address', 'is_active']);
        });
    }
};
