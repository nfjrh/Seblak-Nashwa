<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false; // <-- TAMBAHKAN BARIS INI

    protected $fillable = [
        'id_user',
        'tanggal_pesanan',
        'total_harga',
        'metode_pengambilan',
        'alamat',
        'catatan',
        'status_pesanan',
    ];

    // Konstanta Status Pesanan
    const STATUS_BARU = 'baru';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SIAP = 'siap';
    const STATUS_SELESAI = 'selesai';
    const STATUS_BATAL = 'batal';

    // Konstanta Metode Pengambilan
    const AMBIL = 'ambil';
    const ANTAR = 'antar';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    public function scopeMilikUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    public function scopeStatusAktif($query)
    {
        return $query->whereIn('status_pesanan', [self::STATUS_BARU, self::STATUS_DIPROSES, self::STATUS_SIAP]);
    }

    public function getTotalRupiahAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getLabelStatusAttribute()
    {
        return match($this->status_pesanan) {
            self::STATUS_BARU => 'Baru',
            self::STATUS_DIPROSES => 'Diproses',
            self::STATUS_SIAP => 'Siap Diambil/Diantar',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_BATAL => 'Dibatalkan',
            default => ucfirst($this->status_pesanan),
        };
    }

    public function setCatatanAttribute($value)
    {
        $this->attributes['catatan'] = trim($value);
    }
}