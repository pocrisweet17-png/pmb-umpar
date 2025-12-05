<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->boolean('is_prodi_selected')->default(false);
            $table->boolean('is_bayar_pendaftaran')->default(false);
            $table->boolean('is_data_completed')->default(false);
            $table->boolean('is_dokumen_uploaded')->default(false);
            $table->boolean('is_tes_selesai')->default(false);
            $table->boolean('is_wawancara_selesai')->default(false);
            $table->boolean('is_daftar_ulang')->default(false);
            $table->boolean('is_ukt_paid')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->dropColumn([
                'is_prodi_selected',
                'is_bayar_pendaftaran',
                'is_data_completed',
                'is_dokumen_uploaded',
                'is_tes_selesai',
                'is_wawancara_selesai',
                'is_daftar_ulang',
                'is_ukt_paid',
            ]);
        });
    }
};
