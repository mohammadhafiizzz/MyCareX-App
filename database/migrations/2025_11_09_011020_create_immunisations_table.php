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
        Schema::create('immunisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('vaccine_name');
            $table->string('dose_details', 100)->nullable();
            $table->date('vaccination_date');
            $table->string('administered_by')->nullable();
            $table->string('vaccine_lot_number', 100)->nullable();
            $table->enum('verification_status', ['Unverified', 'Provider Confirmed', 'Patient Reported'])->default('Unverified');
            $table->string('certificate_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immunisations');
    }
};
