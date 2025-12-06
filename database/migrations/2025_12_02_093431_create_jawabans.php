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
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id('idJawaban');
            $table->unsignedBigInteger('idUjian');
            $table->unsignedBigInteger('idSoal');
            $table->string('JawabanPeserta');
            $table->timestamps();

            $table->foreign('idSoal')->references('idSoal')->on('soals')->onDelete('cascade');
            $table->foreign('idUjian')->references('idUjian')->on('ujians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
