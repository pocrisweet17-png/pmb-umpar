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
        Schema::create('dokumens', function (Blueprint $table) {
    $table->id('idDokumen');
    $table->unsignedBigInteger('idRegistrasi');
    $table->string('jenisDokumen'); // ijazah, ktp, dll
    $table->string('namaFile');
    $table->string('formatFile');
    $table->string('urlFile');
    $table->date('tanggalUpload');
    $table->decimal('ukuranVerifikasi', 2, 2)->nullable();
    $table->boolean('catatanVerifikasi')->default(false);
    $table->timestamps();

    $table->foreign('idRegistrasi')->references('idRegistrasi')->on('registrasis');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokuments');
    }
};
