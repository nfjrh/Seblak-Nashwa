<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class DetailKeranjang extends Model
{
    // Constant: batas jumlah per item (sebelumnya angka 20 tertulis langsung)
    const JUMLAH_MIN = 1;
    const JUMLAH_MAKS = 20;

    // Constant: panjang maksimal catatan untuk dapur
    const CATATAN_MAKS = 200;

    protected $table = 'detail_keranjang';
    protected $primaryKey = 'id_detail_keranjang';
    public $timestamps = false;

    protected $fillable = ['id_keranjang', 'id_menu', 'id_level', 'jumlah', 'catatan'];

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    public function levelPedas()
    {
        return $this->belongsTo(LevelPedas::class, 'id_level', 'id_level');
    }

    public function toppings()
    {
        return $this->belongsToMany(
            Topping::class,
            'detail_keranjang_topping',
            'id_detail_keranjang',
            'id_topping'
        );
    }

    // Mutator: jumlah selalu dijaga di antara JUMLAH_MIN dan JUMLAH_MAKS
    protected function jumlah(): Attribute
    {
        return Attribute::make(
            set: fn ($nilai) => max(self::JUMLAH_MIN, min(self::JUMLAH_MAKS, (int) $nilai))
        );
    }

    // Mutator: catatan dirapikan, dan catatan kosong disimpan sebagai null
    protected function catatan(): Attribute
    {
        return Attribute::make(
            set: fn ($nilai) => ($nilai === null || trim($nilai) === '') ? null : trim($nilai)
        );
    }

    // Accessor: $item->subtotal_rupiah
    protected function subtotalRupiah(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->subtotal(), 0, ',', '.')
        );
    }

    /** Harga satu porsi: menu + tambahan level pedas + semua topping. */
    public function hargaSatuan(): float
    {
        return (float) ($this->menu->harga ?? 0)
            + (float) ($this->levelPedas->tambahan_harga ?? 0)
            + (float) $this->toppings->sum('harga');
    }

    /** Harga satu porsi dikali jumlah. */
    public function subtotal(): float
    {
        return $this->hargaSatuan() * $this->jumlah;
    }
}
