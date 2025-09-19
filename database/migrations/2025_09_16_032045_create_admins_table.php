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
        Schema::create('admins', function (Blueprint $table) {
            $table->string('admin_id', 8)->primary();
            $table->string('full_name', 100);
            $table->string('ic_number', 20)->unique();
            $table->string('phone_number', 15);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', ['superadmin', 'admin'])->default('admin');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
