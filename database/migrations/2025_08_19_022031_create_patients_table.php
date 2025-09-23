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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('ic_number', 20)->unique();
            $table->string('phone_number', 15);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('blood_type', 10);
            $table->string('race', 20);
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->longText('address');
            $table->string('postal_code', 5);
            $table->enum('state', ['Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur', 'Labuan', 'Putrajaya']);
            $table->string('emergency_contact_number', 15);
            $table->string('emergency_contact_name', 100);
            $table->string('emergency_contact_ic_number', 20);
            $table->string('emergency_contact_relationship', 30);
            $table->string('profile_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
