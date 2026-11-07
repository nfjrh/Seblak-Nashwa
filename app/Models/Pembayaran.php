<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false; // <-- TAMBAHKAN JUGA DI SINI

    protected $fillable = [
        'id_pesanan',
        'metode_pembayaran',
        'jumlah_pembayaran',
        'status_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran',
    ];

    // Konstanta Status Pembayaran
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_LUNAS = 'lunas';
    const STATUS_DITOLAK = 'ditolak';

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status_pembayaran', self::STATUS_MENUNGGU);
    }

    public function getJumlahRupiahAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_pembayaran, 0, ',', '.');
    }
}