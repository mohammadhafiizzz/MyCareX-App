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
        // First, clean existing data - extract numeric values from string dosages
        \DB::table('medications')->get()->each(function ($medication) {
            $dosageValue = preg_replace('/[^0-9]/', '', $medication->dosage);
            \DB::table('medications')
                ->where('id', $medication->id)
                ->update(['dosage' => (int)$dosageValue ?: 0]);
        });

        // Now change the column type to unsigned integer
        Schema::table('medications', function (Blueprint $table) {
            $table->unsignedInteger('dosage')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            // Revert dosage column back to string
            $table->string('dosage', 100)->change();
        });
    }
};
