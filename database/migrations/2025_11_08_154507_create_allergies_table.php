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
        Schema::create('allergies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('allergen', 150);
            $table->string('reaction', 150);
            $table->enum('severity', ['Mild', 'Moderate', 'Severe', 'Life-threatening'])->default('Mild');
            $table->text('reaction_desc')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Resolved', 'Suspected'])->default('Active');
            $table->enum('verification_status', ['Unverified', 'Provider Confirmed', 'Patient Reported'])->default('Unverified');
            $table->date('first_ovbserved_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergies');
    }
};
