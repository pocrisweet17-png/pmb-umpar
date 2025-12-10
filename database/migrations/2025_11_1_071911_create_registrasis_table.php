<?php
// database/migrations/2025_11_26_071911_create_registrasis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrasis', function (Blueprint $table) {
            $table->id('idRegistrasi');
            
            // Reference ke users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomorPendaftaran')->unique();
            
            // Data Pribadi
            $table->string('jenisKelamin')->nullable();
            $table->string('tempatLahir')->nullable();
            $table->date('tanggalLahir')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            
            // Data Sekolah
            $table->string('asalSekolah')->nullable();
            $table->string('jurusan')->nullable();
            $table->integer('tahunLulus')->nullable();
            
            // Program Studi Pilihan
            $table->string('programStudiPilihan')->nullable();
            
            // Status & Tanggal
            $table->date('tanggalDaftar')->nullable();
            $table->enum('statusRegistrasi', ['pending', 'lunas', 'diterima', 'ditolak'])
                  ->default('pending');
            
            $table->timestamps();
            
            // Index untuk performance
            $table->index('user_id');
            $table->index('nomorPendaftaran');
        });
        
        // Tambahkan foreign key setelah tabel dibuat (jika program_studis sudah ada)
        Schema::table('registrasis', function (Blueprint $table) {
             $table->foreign('programStudiPilihan')
                   ->references('kodeProdi')
                   ->on('program_studis')
                   ->onDelete('set null');
         });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrasis');
    }
};