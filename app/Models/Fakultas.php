<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    
    protected $fillable = [
        'kode_fakultas',
        'nama_fakultas',
        'singkatan',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Relasi ke Program Studi
     */
    public function programStudis(): HasMany
    {
        return $this->hasMany(ProgramStudy::class, 'fakultas_id');
    }

    /**
     * Relasi ke Users (Dekan)
     */
    public function dekans(): HasMany
    {
        return $this->hasMany(User::class, 'fakultas_id')
                    ->where('role', 'dekan');
    }
}

