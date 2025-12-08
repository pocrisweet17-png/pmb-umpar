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
        Schema::table('registrasis', function (Blueprint $table) {
        $table->string('jenisKelamin')->nullable()->change();
        $table->string('tempatLahir')->nullable()->change();
        $table->date('tanggalLahir')->nullable()->change();
        $table->string('agama')->nullable()->change();
        $table->string('alamat')->nullable()->change();
        $table->string('asalSekolah')->nullable()->change();
        $table->string('jurusan')->nullable()->change();
        $table->integer('tahunLulus')->nullable()->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
