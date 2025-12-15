<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            
            // Reference ke users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('nim')->unique();
            $table->string('namaLengkap');
            $table->string('kodeProdi');
            $table->string('angkatan');
            $table->string('statusMahasiswa')->default('aktif'); // aktif, cuti, lulus, DO
            $table->date('tanggalDaftar');
            $table->unsignedBigInteger('noPDDikti')->nullable();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('kodeProdi')
                  ->references('kodeProdi')
                  ->on('program_studis')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
