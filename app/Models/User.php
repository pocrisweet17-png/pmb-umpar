<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'nama_lengkap',
        'jenisKelamin',
        'nik',
        'no_whatsapp',
        'role',
        'registration_number',
        'is_verified',
        'email_verified_at',
        'pilihan_1',
        'pilihan_2',
        'is_prodi_selected',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
