<?php
// app/Models/Dokument.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumens';
    protected $primaryKey = 'idDokumen';

    protected $fillable = [
        'user_id',
        'jenisDokumen',
        'namaFile',
        'formatFile',
        'urlFile',
        'tanggalUpload',
        'statusVerifikasi',
        'catatanVerifikasi',
    ];

    protected $casts = [
        'tanggalUpload' => 'date',
        'statusVerifikasi' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Untuk backward compatibility
    public function getIdRegistrasiAttribute()
    {
        return $this->user_id;
    }

    // ========== SCOPES ==========
    
    public function scopeVerified($query)
    {
        return $query->where('statusVerifikasi', true);
    }

    public function scopeUnverified($query)
    {
        return $query->where('statusVerifikasi', false);
    }
}