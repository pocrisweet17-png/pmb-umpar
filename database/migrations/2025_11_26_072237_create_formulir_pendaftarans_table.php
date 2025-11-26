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
    $table->string('nomorPendaftaran');
    $table->string('tanggalSubmit');
    $table->string('programStudiPilihan');
    $table->string('statusVerifikasi')->default('menunggu');
    $table->string('kodeAkses')->unique(); // untuk login calon maba
    $table->timestamps();

    $table->foreign('nomorPendaftaran')->references('nomorPendaftaran')->on('registrasis');
    $table->foreign('programStudiPilihan')->references('kodeProdi')->on('program_studis');
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
