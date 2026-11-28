<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_inquiries', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->string('name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('topic')->nullable();
            $table->text('message');
            $table->string('status', 20)->default('pending')->index();
            $table->string('resolved_by')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_inquiries');
    }
};
