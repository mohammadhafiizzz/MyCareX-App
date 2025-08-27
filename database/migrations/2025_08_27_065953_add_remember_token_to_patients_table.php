<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'remember_token')) {
                $table->rememberToken()->nullable()->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};