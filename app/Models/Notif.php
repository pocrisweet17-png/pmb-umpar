<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['registrasi_id','title','message','is_read'];

    public function registrasi()
    {
        return $this->belongsTo(\App\Models\Registrasi::class, 'registrasi_id', 'idRegistrasi');
    }
}
