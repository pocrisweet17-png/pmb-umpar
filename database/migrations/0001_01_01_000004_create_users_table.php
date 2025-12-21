<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nama_lengkap');
            $table->string('nik')->unique();

            // sosmed
            $table->string('no_whatsapp');
            $table->string('akun_fb')->unique()->nullable();
            $table->string('akun_instagram')->unique()->nullable();
            
            // Email verification
            $table->boolean('is_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_token')->nullable();
            
            // Nomor registrasi (auto-generated)
            $table->string('nomor_registrasi')->unique()->nullable();
            $table->string('nomorPendaftaran')->unique()->nullable();
            
            // Pilihan Program Studi
            $table->string('pilihan_1')->nullable(); // kodeProdi pilihan 1
            $table->string('pilihan_2')->nullable(); // kodeProdi pilihan 2
            
            // ========== STEP PROGRESS PMB ==========
            $table->boolean('is_prodi_selected')->default(false);
            $table->boolean('is_bayar_pendaftaran')->default(false);
            $table->boolean('is_data_completed')->default(false);
            $table->boolean('is_dokumen_uploaded')->default(false);
            $table->boolean('is_tes_selesai')->default(false);
            $table->boolean('is_wawancara_selesai')->default(false);
            $table->boolean('is_daftar_ulang')->default(false);
            $table->boolean('is_ukt_paid')->default(false);
            
            // Role
            $table->enum('role', ['admin', 'user'])->default('user');
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
