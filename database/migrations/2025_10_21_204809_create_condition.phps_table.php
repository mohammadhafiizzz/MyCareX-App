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
        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('condition_name', 150);
            $table->date('diagnosis_date')->nullable();
            $table->text('description')->nullable();
            $table->enum('severity', ['Mild', 'Moderate', 'Severe'])->default('Mild');
            $table->enum('status', ['Active', 'Resolved', 'Chronic'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conditions');
    }
};
