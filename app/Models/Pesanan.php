<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_user', 'tanggal_pesanan', 'total_harga', 'metode_pengambilan',
        'alamat', 'catatan', 'status_pesanan',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }
}
