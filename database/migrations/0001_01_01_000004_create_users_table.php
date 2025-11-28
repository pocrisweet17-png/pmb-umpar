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

            // Data login
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            // Data mahasiswa
            $table->string('nama_lengkap');
            $table->string('nik')->unique(); // No KTP / KK
            $table->string('no_whatsapp');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);

            // Role untuk akses admin / user
            $table->enum('role', ['admin', 'user'])->default('user');

            // Fitur Laravel
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
