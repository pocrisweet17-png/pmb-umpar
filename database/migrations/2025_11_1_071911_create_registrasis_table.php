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
        Schema::create('registrasis', function (Blueprint $table) {
    $table->id('idRegistrasi');
    $table->string('nomorPendaftaran')->unique();
    $table->string('namaLengkap');
    $table->string('tempatLahir');
    $table->date('tanggalLahir');
    $table->string('agama');
    $table->string('alamat');
    $table->string('asalSekolah');
    $table->string('jurusan');
    $table->integer('tahunLulus');
    $table->date('tanggalDaftar');
    $table->enum('statusRegistrasi', ['pending', 'lunas', 'diterima', 'ditolak'])->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasis');
    }
};
