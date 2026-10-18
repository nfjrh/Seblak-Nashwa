<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    protected $table = 'topping';
    protected $primaryKey = 'id_topping';
    public $timestamps = false;

    protected $fillable = ['nama_topping', 'harga', 'stok'];

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
