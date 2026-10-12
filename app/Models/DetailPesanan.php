<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;
    protected $guarded = [];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    public function levelPedas()
    {
        return $this->belongsTo(LevelPedas::class, 'id_level', 'id_level');
    }

    public function topping()
    {
        return $this->belongsToMany(
            Topping::class,
            'detail_pesanan_topping',
            'id_detail',
            'id_topping'
        )->withPivot('harga');
    }
}