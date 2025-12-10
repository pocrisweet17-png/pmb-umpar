<?php
// 2025_11_26_072011_create_program_studis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_studis', function (Blueprint $table) {
            $table->string('kodeProdi')->primary();
            $table->string('namaProdi');
            $table->string('jenjang'); // S1, S2, S3, Profesi
            $table->string('fakultas');
            $table->integer('kuota');
            $table->double('passingGrade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_studis');
    }
};