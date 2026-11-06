<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = false;

    protected $fillable = ['id_user', 'tanggal_dibuat'];

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailKeranjangs()
    {
        return $this->hasMany(DetailKeranjang::class, 'id_keranjang', 'id_keranjang');
    }

    // Accessor: $keranjang->total (angka) dan $keranjang->total_rupiah (teks)
    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->detailKeranjangs->sum(fn ($d) => $d->subtotal())
        );
    }

    protected function totalRupiah(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->total, 0, ',', '.')
        );
    }

    // Static method: ambil keranjang milik user, buat baru kalau belum ada
    public static function milikUser(int $idUser): self
    {
        return static::firstOrCreate(['id_user' => $idUser]);
    }
}
