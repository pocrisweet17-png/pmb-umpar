<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'id_registrasi',
        'order_id',
        'id_transaksi',
        'jumlah',
        'tipe_pembayaran',
        'status_transaksi',
        'bukti_manual',
        'payload',
    ];

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'id_registrasi');
    }
}