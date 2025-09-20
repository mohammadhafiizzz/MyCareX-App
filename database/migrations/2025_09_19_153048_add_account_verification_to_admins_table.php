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
        Schema::table('admins', function (Blueprint $table) {
            // Add verification attributes for admin accounts
            $table->timestamp('account_verified_at')->nullable()->after('email_verified_at');
            $table->string('account_verified_by', 7)->nullable()->after('account_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Remove verification attributes
            $table->dropColumn(['account_verified_at', 'account_verified_by']);
        });
    }
};
