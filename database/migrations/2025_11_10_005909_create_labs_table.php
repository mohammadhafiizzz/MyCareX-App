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
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('test_name', 150);
            $table->date('test_date');
            $table->string('file_attachment_url');
            $table->string('test_category', 100);
            $table->string('facility_name')->nullable();
            $table->enum('verification_status', ['Unverified', 'Provider Confirmed', 'Patient Reported'])->default('Unverified');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};
