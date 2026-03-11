<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('idAdmin');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('namaLengkap');
            $table->string('role'); // super_admin, admin_prodi, admin_keuangan
            $table->boolean('statusAktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
