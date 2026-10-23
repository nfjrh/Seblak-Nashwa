<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKeranjang extends Model
{
    protected $table = 'detail_keranjang';
    protected $primaryKey = 'id_detail_keranjang';
    public $timestamps = false;

    protected $fillable = ['id_keranjang', 'id_menu', 'id_level', 'jumlah'];

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
