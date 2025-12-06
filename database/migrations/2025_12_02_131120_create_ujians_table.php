<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ujians', function (Blueprint $table) {
            $table->id('idUjian');
            $table->unsignedBigInteger('idUser');
            $table->dateTime('waktuMulai')->nullable();
            $table->dateTime('waktuSelesai')->nullable();
            $table->enum('status', ['belum_mulai', 'sedang_berlangsung', 'selesai'])->default('belum_mulai');
            $table->decimal('nilaiAkhir', 5, 2)->nullable();
            $table->integer('jumlahBenar')->default(0);
            $table->integer('jumlahSalah')->default(0);
            $table->timestamps();

            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
