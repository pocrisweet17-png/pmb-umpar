<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaftarUlangColumnsToMahasiswasTable extends Migration
{
    public function up()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('semester')->default('1')->after('statusMahasiswa');
            $table->string('tahun_akademik')->default('2026/2027')->after('semester');
            $table->string('bukti_pembayaran')->nullable()->after('tahun_akademik');
            $table->boolean('pernyataan_daftar_ulang')->default(false)->after('bukti_pembayaran');
            $table->boolean('is_daftar_ulang')->default(false)->after('pernyataan_daftar_ulang');
            $table->timestamp('tanggal_daftar_ulang')->nullable()->after('is_daftar_ulang');
            $table->enum('status_daftar_ulang', ['belum', 'pending', 'verified', 'rejected'])->default('belum')->after('tanggal_daftar_ulang');
        });
    }

    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn([
                'semester',
                'tahun_akademik',
                'bukti_pembayaran',
                'pernyataan_daftar_ulang',
                'is_daftar_ulang',
                'tanggal_daftar_ulang',
                'status_daftar_ulang'
            ]);
        });
    }
}