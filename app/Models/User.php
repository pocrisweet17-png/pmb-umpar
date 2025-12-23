<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'nama_lengkap',
        'nik',
        'no_whatsapp',
        'akun_fb',
        'akun_instagram',
        'akun_tiktok',
        'akun_twitter',
        'is_verified',
        'email_verified_at',
        'verification_token',
        'nomor_registrasi',
        'nim',
        'pilihan_1',
        'pilihan_2',
        'is_prodi_selected',
        'is_bayar_pendaftaran',
        'is_data_completed',
        'is_dokumen_uploaded',
        'is_tes_selesai',
        'is_wawancara_selesai',
        'is_daftar_ulang',
        'is_ukt_paid',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
        'is_prodi_selected' => 'boolean',
        'is_bayar_pendaftaran' => 'boolean',
        'is_data_completed' => 'boolean',
        'is_dokumen_uploaded' => 'boolean',
        'is_tes_selesai' => 'boolean',
        'is_wawancara_selesai' => 'boolean',
        'is_daftar_ulang' => 'boolean',
        'is_ukt_paid' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function registrasi()
    {
        return $this->hasOne(Registrasi::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'user_id');
    }

    // public function mahasiswa()
    // {
    //     return $this->hasOne(Mahasiswa::class, 'user_id');
    // }

    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class, 'user_id');
    // }

    // ========== ACCESSORS ==========
    
    public function getNameAttribute()
    {
        return $this->nama_lengkap;
    }

    // Untuk kompatibilitas dengan kode lama
    public function getKodeProdi1Attribute()
    {
        return $this->pilihan_1;
    }

    public function getKodeProdi2Attribute()
    {
        return $this->pilihan_2;
    }

    // ========== SCOPES ==========
    
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }
    public function programStudiPilihan1()
    {
        return $this->belongsTo(ProgramStudy::class, 'pilihan_1', 'kodeProdi');
    }

    // Relasi ke program studi untuk pilihan_2 (jika ada)
    public function programStudiPilihan2()
    {
        return $this->belongsTo(ProgramStudy::class, 'pilihan_2', 'kodeProdi');
    }

    // Accessor untuk mendapatkan nama prodi pilihan 1
    public function getNamaProdiPilihan1Attribute()
    {
        return $this->programStudiPilihan1 ? $this->programStudiPilihan1->namaProdi : $this->pilihan_1;
    }
}
