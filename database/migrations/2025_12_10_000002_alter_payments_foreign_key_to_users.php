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
        Schema::table('payments', function (Blueprint $table) {
            // Drop foreign key lama
            $table->dropForeign(['id_registrasi']);
            
            // Ubah foreign key ke users table
            $table->foreign('id_registrasi')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop foreign key ke users
            $table->dropForeign(['id_registrasi']);
            
            // Kembalikan ke registrasis
            $table->foreign('id_registrasi')
                  ->references('idRegistrasi')
                  ->on('registrasis')
                  ->onDelete('cascade');
        });
    }
};
