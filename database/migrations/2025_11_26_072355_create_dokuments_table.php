<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id('idDokumen');
            
            // Reference ke users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Jenis: KTP, Ijazah, Foto, Kartu Keluarga, dll
            $table->string('jenisDokumen');
            $table->string('namaFile');
            $table->string('formatFile'); // jpg, pdf, png
            $table->string('urlFile'); // path storage
            $table->date('tanggalUpload');
            
            // Verifikasi admin
            $table->boolean('statusVerifikasi')->default(false);
            $table->text('catatanVerifikasi')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
