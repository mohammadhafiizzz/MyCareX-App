<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conditions', function (Blueprint $table) {
            $table->string('doc_attachments_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('conditions', function (Blueprint $table) {
            $table->json('doc_attachments_url')->nullable()->change();
        });
    }
};