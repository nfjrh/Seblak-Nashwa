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
}
