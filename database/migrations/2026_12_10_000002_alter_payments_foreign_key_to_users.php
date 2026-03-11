<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            // cek dulu apakah foreign key ada
            try {
                $table->dropForeign(['id_registrasi']);
            } catch (\Exception $e) {
                // abaikan jika tidak ada
            }

            // buat foreign key baru
            $table->foreign('id_registrasi')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            try {
                $table->dropForeign(['id_registrasi']);
            } catch (\Exception $e) {
                //
            }

            $table->foreign('id_registrasi')
                  ->references('idRegistrasi')
                  ->on('registrasis')
                  ->onDelete('cascade');
        });
    }
};