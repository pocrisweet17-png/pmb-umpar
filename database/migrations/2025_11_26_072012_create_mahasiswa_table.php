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
        Schema::create('mahasiswas', function (Blueprint $table) {
    $table->id();
    $table->string('nim')->unique();
    $table->string('namaLengkap');
    $table->string('kodeProdi');
    $table->string('angkatan');
    $table->string('statusMahasiswa')->default('aktif');
    $table->date('tanggalDaftar');
    $table->unsignedBigInteger('noPDDikti')->nullable();
    $table->timestamps();
    $table->foreign('kodeProdi')->references('kodeProdi')->on('program_studis');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
