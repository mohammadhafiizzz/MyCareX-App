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
        Schema::table('healthcare_providers', function (Blueprint $table) {
            $table->string('organisation_type', 100)->nullable()->change();
            $table->date('establishment_date')->nullable()->change();
            $table->string('phone_number', 15)->nullable()->change();
            $table->string('emergency_contact', 50)->nullable()->change();
            $table->string('contact_person_phone_number', 15)->nullable()->change();
            $table->string('contact_person_designation', 100)->nullable()->change();
            $table->string('contact_person_ic_number', 20)->nullable()->change();
            $table->longText('address')->nullable()->change();
            $table->string('postal_code', 5)->nullable()->change();
            $table->enum('state', ['Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur', 'Labuan', 'Putrajaya'])->nullable()->change();
            $table->date('registration_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('healthcare_providers', function (Blueprint $table) {
            $table->string('organisation_type', 100)->nullable(false)->change();
            $table->date('establishment_date')->nullable(false)->change();
            $table->string('phone_number', 15)->nullable(false)->change();
            $table->string('emergency_contact', 50)->nullable(false)->change();
            $table->string('contact_person_phone_number', 15)->nullable(false)->change();
            $table->string('contact_person_designation', 100)->nullable(false)->change();
            $table->string('contact_person_ic_number', 20)->nullable(false)->change();
            $table->longText('address')->nullable(false)->change();
            $table->string('postal_code', 5)->nullable(false)->change();
            $table->enum('state', ['Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur', 'Labuan', 'Putrajaya'])->nullable(false)->change();
            $table->date('registration_date')->nullable(false)->change();
        });
    }
};
