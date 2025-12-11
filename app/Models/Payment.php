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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_registrasi');
    }
}