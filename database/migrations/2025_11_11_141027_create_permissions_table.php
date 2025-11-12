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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('provider_id')->constrained('healthcare_providers')->onDelete('cascade');
            $table->date('requested_at');
            $table->date('granted_at')->nullable();
            $table->enum('status', ['Pending', 'Active', 'Denied', 'Revoked', 'Expired'])->default('Pending');
            $table->date('expiry_date')->nullable();
            $table->json('permission_scope')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
