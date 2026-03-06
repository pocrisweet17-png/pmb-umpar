<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $table = 'ujians';
    protected $primaryKey = 'idUjian';

    protected $fillable = [
        'idUser',
        'waktuMulai',
        'waktuSelesai',
        'status',
        'nilaiAkhir',
        'jumlahBenar',
        'jumlahSalah'
    ];


    protected $casts = [
        'waktuMulai' => 'datetime',
        'waktuSelesai' => 'datetime',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
    public function jawabans(){
        return $this->hasMany(Jawaban::class,'idUjian', 'idUjian');
    }
}
