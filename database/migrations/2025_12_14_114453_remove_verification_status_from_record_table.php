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
        if (Schema::hasColumn('labs', 'verification_status')) {
            Schema::table('labs', function (Blueprint $table) {
                $table->dropColumn('verification_status');
            });
        }

        if (Schema::hasColumn('immunisations', 'verification_status')) {
            Schema::table('immunisations', function (Blueprint $table) {
                $table->dropColumn('verification_status');
            });
        }

        if (Schema::hasColumn('allergies', 'verification_status')) {
            Schema::table('allergies', function (Blueprint $table) {
                $table->dropColumn('verification_status');
            });
        }

        if (Schema::hasColumn('surgeries', 'verification_status')) {
            Schema::table('surgeries', function (Blueprint $table) {
                $table->dropColumn('verification_status');
            });
        }

        if (Schema::hasColumn('hospitalisations', 'verification_status')) {
            Schema::table('hospitalisations', function (Blueprint $table) {
                $table->dropColumn('verification_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('labs', 'verification_status')) {
            Schema::table('labs', function (Blueprint $table) {
                $table->string('verification_status')->nullable();
            });
        }

        if (!Schema::hasColumn('immunisations', 'verification_status')) {
            Schema::table('immunisations', function (Blueprint $table) {
                $table->string('verification_status')->nullable();
            });
        }

        if (!Schema::hasColumn('allergies', 'verification_status')) {
            Schema::table('allergies', function (Blueprint $table) {
                $table->string('verification_status')->nullable();
            });
        }

        if (!Schema::hasColumn('surgeries', 'verification_status')) {
            Schema::table('surgeries', function (Blueprint $table) {
                $table->string('verification_status')->nullable();
            });
        }

        if (!Schema::hasColumn('hospitalisations', 'verification_status')) {
            Schema::table('hospitalisations', function (Blueprint $table) {
                $table->string('verification_status')->nullable();
            });
        }
    }
};
