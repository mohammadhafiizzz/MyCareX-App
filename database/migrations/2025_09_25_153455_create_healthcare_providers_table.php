<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('healthcare_providers', function (Blueprint $table) {
            $table->id();
            $table->string('organisation_name', 150);
            $table->string('organisation_type', 100);
            $table->string('registration_number', 100)->unique()->nullable();
            $table->string('license_number', 100)->unique()->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->date('establishment_date');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->rememberToken();
            $table->string('phone_number', 15);
            $table->string('emergency_contact', 50);
            $table->string('website_url', 100)->nullable();
            $table->string('contact_person_name', 100);
            $table->string('contact_person_phone_number', 15);
            $table->string('contact_person_designation', 100);
            $table->string('contact_person_ic_number', 20)->unique();
            $table->longText('address');
            $table->string('postal_code', 5);
            $table->enum('state', ['Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur', 'Labuan', 'Putrajaya']);
            $table->string('business_license_document')->nullable();
            $table->string('medical_license_document')->nullable();
            $table->string('profile_image_url')->nullable();
            $table->date('registration_date');
            $table->enum('verification_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('verified_by')->nullable();
            $table->date('approved_at')->nullable();
            $table->date('rejected_at')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('healthcare_providers');
    }
};
