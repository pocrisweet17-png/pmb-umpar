<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formulir_pendaftarans', function (Blueprint $table) {
            $table->id('idFormulir');
            
            // Reference ke users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomorPendaftaran')->unique();
            $table->boolean('is_tes_selesai')->default(false);
            
            $table->date('tanggalSubmit');
            $table->string('programStudiPilihan');
            $table->enum('statusVerifikasi', ['menunggu', 'diverifikasi', 'ditolak'])
                  ->default('menunggu');
            $table->string('kodeAkses', 10)->unique();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('programStudiPilihan')
                  ->references('kodeProdi')
                  ->on('program_studis')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formulir_pendaftarans');
    }
};