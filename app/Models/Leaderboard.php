<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    protected $table = 'leaderboards';
    protected $primaryKey = 'idLeaderboard';

    protected $fillable = [
        'idUser',
        'idUjian',
        'nilai'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
    public function ujian(){
        return $this->belongsTo(Ujian::class, 'idUjian', 'idUjian');
    }
}
