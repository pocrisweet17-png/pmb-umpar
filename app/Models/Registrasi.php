<?php
// app/Models/Registrasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory;

    protected $table = 'registrasis';
    protected $primaryKey = 'idRegistrasi';

    protected $fillable = [
        'user_id',
        'id',
        'nomorPendaftaran',
        'jenisKelamin',
        'tempatLahir',
        'tanggalLahir',
        'agama',
        'alamat',
        'asalSekolah',
        'jurusan',
        'tahunLulus',
        'programStudiPilihan',
        'tanggalDaftar',
        'statusRegistrasi',
    ];

    protected $casts = [
        'tanggalLahir' => 'date',
        'tanggalDaftar' => 'date',
        'tahunLulus' => 'integer',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Program Studi (jika ada)
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudy::class, 'programStudiPilihan', 'kodeProdi');
    }

    /**
     * Relasi ke Dokumen
     */
    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'user_id', 'user_id');
    }
}