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
        Schema::table('medications', function (Blueprint $table) {
            // Change the status enum to match the form options
            $table->enum('status', ['Active', 'On Hold', 'Completed', 'Discontinued'])->default('Active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            // Revert back to original enum values
            $table->enum('status', ['Active', 'Inactive', 'Paused'])->default('Active')->change();
        });
    }
};
