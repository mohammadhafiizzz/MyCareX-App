<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('healthcare_providers')->onDelete('cascade');
            $table->string('full_name', 150);
            $table->string('ic_number', 20);
            $table->string('email', 100);
            $table->string('password');
            $table->string('phone_number', 15);
            $table->string('medical_license_number', 100);
            $table->enum('specialisation', ['General Practitioner', 'Cardiologist', 'Dermatologist', 'Neurologist', 'Pediatrician', 'Psychiatrist', 'Radiologist', 'Surgeon'])->default('General Practitioner')->nullable();
            $table->boolean('active_status')->default(true);
            $table->string('profile_image_url')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
