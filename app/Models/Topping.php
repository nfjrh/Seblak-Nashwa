<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    // Constant: batas stok
    const STOK_HABIS = 0;
    const STOK_MENIPIS = 5;

    protected $table = 'topping';
    protected $primaryKey = 'id_topping';
    public $timestamps = false;

    protected $fillable = ['nama_topping', 'harga', 'stok'];

    // Mutator: nama topping selalu rapi (huruf awal besar)
    protected function namaTopping(): Attribute
    {
        return Attribute::make(
            set: fn ($nilai) => ucwords(strtolower(trim($nilai)))
        );
    }

    // Accessor: $topping->harga_rupiah
    protected function hargaRupiah(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->harga, 0, ',', '.')
        );
    }

    // Accessor: $topping->status_stok  -> Habis / Menipis / Tersedia
    protected function statusStok(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->stok <= self::STOK_HABIS) {
                    return 'Habis';
                }
                return $this->stok <= self::STOK_MENIPIS ? 'Menipis' : 'Tersedia';
            }
        );
    }

    // Static method: Topping::menipis()->get()
    public static function menipis()
    {
        return static::where('stok', '<=', self::STOK_MENIPIS);
    }

    public function detailKeranjangs()
    {
        return $this->belongsToMany(
            DetailKeranjang::class,
            'detail_keranjang_topping',
            'id_topping',
            'id_detail_keranjang'
        );
    }

    public function detailPesanans()
    {
        return $this->belongsToMany(
            DetailPesanan::class,
            'detail_pesanan_topping',
            'id_topping',
            'id_detail'
        )->withPivot('harga');
    }
}
