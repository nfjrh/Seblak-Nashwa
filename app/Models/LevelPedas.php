<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelPedas extends Model
{
    protected $table = 'level_pedas';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    protected $fillable = ['nama_level', 'tambahan_harga'];

    public function detailKeranjangs()
    {
        return $this->hasMany(DetailKeranjang::class, 'id_level', 'id_level');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_level', 'id_level');
    }
}
