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
            $table->dropForeign(['provider_id']);
            $table->dropColumn('provider_id');
        });
        
        Schema::table('medications', function (Blueprint $table) {
            $table->foreignId('provider_id')->nullable()->constrained('healthcare_providers')->onDelete('set null')->after('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropForeign(['provider_id']);
            $table->dropColumn('provider_id');
        });
        
        Schema::table('medications', function (Blueprint $table) {
            $table->foreignId('provider_id')->constrained('healthcare_providers')->onDelete('cascade')->after('patient_id');
        });
    }
};
