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
        Schema::create('formulir_pendaftarans', function (Blueprint $table) {
        $table->id('idFormulir');
        $table->string('nomorPendaftaran')->unique(); // 1 formulir = 1 pendaftar
        $table->date('tanggalSubmit');
        $table->string('programStudiPilihan'); // kodeProdi
        $table->enum('statusVerifikasi', ['menunggu', 'diverifikasi', 'ditolak'])
              ->default('menunggu');
        $table->string('kodeAkses', 10)->unique(); // contoh: AB20250001
        $table->timestamps();

        // Foreign key
        $table->foreign('nomorPendaftaran')
              ->references('nomorPendaftaran')
              ->on('registrasis')
              ->onDelete('cascade');

        $table->foreign('programStudiPilihan')
              ->references('kodeProdi')
              ->on('program_studis');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_pendaftarans');
    }
};
