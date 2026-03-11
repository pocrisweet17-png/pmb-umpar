<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramStudy extends Model
{
    protected $table = 'program_studis'; 
    
    protected $primaryKey = 'kodeProdi';
    
    public $incrementing = false; 
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'kodeProdi',
        'namaProdi',
        'fakultas',
        'fakultas_id',
        'jenjang',
        'kuota',
    ];
    
<<<<<<< HEAD
    public $timestamps = false; // jika tidak pakai created_at/updated_at
=======
    public $timestamps = false;
>>>>>>> c725232840e4de2ca89c207adcd8c9dee52d0523

     public function fakultasRelation(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }
}