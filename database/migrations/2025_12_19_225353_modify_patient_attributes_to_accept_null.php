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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('phone_number', 15)->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->enum('gender', ['Male', 'Female'])->nullable()->change();
            $table->string('blood_type', 10)->nullable()->change();
            $table->string('race', 20)->nullable()->change();
            $table->decimal('height', 5, 2)->nullable()->change();
            $table->decimal('weight', 5, 2)->nullable()->change();
            $table->longText('address')->nullable()->change();
            $table->string('postal_code', 5)->nullable()->change();
            $table->enum('state', ['Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur', 'Labuan', 'Putrajaya'])->nullable()->change();
            $table->string('emergency_contact_number', 15)->nullable()->change();
            $table->string('emergency_contact_name', 100)->nullable()->change();
            $table->string('emergency_contact_ic_number', 20)->nullable()->change();
            $table->string('emergency_contact_relationship', 30)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('phone_number', 15)->nullable(false)->change();
            $table->date('date_of_birth')->nullable(false)->change();
            $table->enum('gender', ['Male', 'Female'])->nullable(false)->change();
            $table->string('blood_type', 10)->nullable(false)->change();
            $table->string('race', 20)->nullable(false)->change();
            $table->decimal('height', 5, 2)->nullable()->change();
            $table->decimal('weight', 5, 2)->nullable()->change();
            $table->longText('address')->nullable(false)->change();
            $table->string('postal_code', 5)->nullable(false)->change();
            $table->enum('state', ['Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur', 'Labuan', 'Putrajaya'])->nullable(false)->change();
            $table->string('emergency_contact_number', 15)->nullable(false)->change();
            $table->string('emergency_contact_name', 100)->nullable(false)->change();
            $table->string('emergency_contact_ic_number', 20)->nullable(false)->change();
            $table->string('emergency_contact_relationship', 30)->nullable(false)->change();
        });
    }
};
