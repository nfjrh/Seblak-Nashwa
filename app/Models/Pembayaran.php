<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan', 'id_verifikator', 'metode_pembayaran', 'tanggal_pembayaran',
        'jumlah_pembayaran', 'status_pembayaran', 'bukti_pembayaran',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // Kasir/admin yang memverifikasi pembayaran
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'id_verifikator', 'id_user');
    }
}
