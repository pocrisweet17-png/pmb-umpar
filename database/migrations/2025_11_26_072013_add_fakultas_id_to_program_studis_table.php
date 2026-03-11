<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            // Cek dulu kalau kolomnya belum ada
            if (!Schema::hasColumn('program_studis', 'fakultas_id')) {
                $table->unsignedInteger('fakultas_id')->nullable()->after('fakultas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            if (Schema::hasColumn('program_studis', 'fakultas_id')) {
                $table->dropColumn('fakultas_id');
            }
        });
    }
};