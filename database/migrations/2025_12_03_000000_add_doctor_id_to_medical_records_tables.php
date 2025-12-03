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
        // Add doctor_id to conditions
        Schema::table('conditions', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->after('patient_id')->constrained()->onDelete('set null');
        });

        // Add doctor_id to allergies
        Schema::table('allergies', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->after('patient_id')->constrained()->onDelete('set null');
        });

        // Add doctor_id to immunisations
        Schema::table('immunisations', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->after('patient_id')->constrained()->onDelete('set null');
        });

        // Add doctor_id to labs
        Schema::table('labs', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->after('patient_id')->constrained()->onDelete('set null');
        });

        // Rename provider_id to doctor_id in medications
        Schema::table('medications', function (Blueprint $table) {
            // Drop the old foreign key constraint first
            $table->dropForeign(['provider_id']);
            // Rename the column
            $table->renameColumn('provider_id', 'doctor_id');
        });

        // Add the new foreign key constraint for medications
        Schema::table('medications', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conditions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('doctor_id');
        });

        Schema::table('allergies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('doctor_id');
        });

        Schema::table('immunisations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('doctor_id');
        });

        Schema::table('labs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('doctor_id');
        });

        // Rename doctor_id back to provider_id in medications
        Schema::table('medications', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->renameColumn('doctor_id', 'provider_id');
        });

        Schema::table('medications', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('healthcare_providers')->onDelete('set null');
        });
    }
};
