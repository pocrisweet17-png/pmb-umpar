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
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom nim setelah nomor_registrasi
            // Nullable karena baru diisi di step bayar UKT
            // Unique untuk memastikan tidak ada NIM duplikat
            $table->string('nim')->nullable()->unique()->after('nomor_registrasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nim');
        });
    }
};