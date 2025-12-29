<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'namaLengkap',
        'kodeProdi',
        'angkatan',
        'statusMahasiswa',
        'tanggalDaftar',
        'noPDDikti',
        'semester',
        'tahun_akademik',
        'bukti_pembayaran',
        'pernyataan_daftar_ulang',
        'is_daftar_ulang',
        'tanggal_daftar_ulang',
        'status_daftar_ulang'
    ];

    protected $casts = [
        'tanggalDaftar' => 'date',
        'tanggal_daftar_ulang' => 'datetime',
        'pernyataan_daftar_ulang' => 'boolean',
        'is_daftar_ulang' => 'boolean',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Program Studi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudy::class, 'kodeProdi', 'kodeProdi');
    }

    // Accessor untuk nama program studi
    public function getNamaProdiAttribute()
    {
        return $this->programStudi ? $this->programStudi->namaProdi : $this->kodeProdi;
    }
    // relasi ke registrasi
        public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'user_id', 'user_id');
    }
}