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
        Schema::create('registrasis', function (Blueprint $table) {
            $table->id('idRegistrasi');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); 
            $table->string('nomorPendaftaran')->unique();
            $table->string('namaLengkap');
            $table->string('jenisKelamin')->nullable(); 
            $table->string('tempatLahir')->nullable(); 
            $table->date('tanggalLahir')->nullable(); 
            $table->string('agama')->nullable(); 
            $table->string('alamat')->nullable(); 
            $table->string('asalSekolah')->nullable(); 
            $table->string('jurusan')->nullable(); 
            $table->integer('tahunLulus')->nullable(); 
            $table->string('programStudiPilihan')->nullable(); 
            $table->date('tanggalDaftar');
            $table->enum('statusRegistrasi', ['pending', 'lunas', 'diterima', 'ditolak'])->default('pending');
            
           
            $table->boolean('is_prodi_selected')->default(0);
            $table->boolean('is_bayar_pendaftaran')->default(0);
            $table->boolean('is_data_completed')->default(0);
            $table->boolean('is_dokumen_uploaded')->default(0);
            $table->boolean('is_tes_selesai')->default(0);
            $table->boolean('is_wawancara_selesai')->default(0);
            $table->boolean('is_daftar_ulang')->default(0);
            $table->boolean('is_ukt_paid')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasis');
    }
};