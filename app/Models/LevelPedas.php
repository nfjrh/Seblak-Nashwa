<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class LevelPedas extends Model
{
    // Constant: batas tambahan harga level pedas
    const TAMBAHAN_HARGA_MAKS = 20000;

    protected $table = 'level_pedas';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    protected $fillable = ['nama_level', 'tambahan_harga'];

    // Mutator: nama level rapi
    protected function namaLevel(): Attribute
    {
        return Attribute::make(
            set: fn ($nilai) => ucwords(strtolower(trim($nilai)))
        );
    }

    // Accessor: $level->tambahan_harga_rupiah
    protected function tambahanHargaRupiah(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tambahan_harga > 0
                ? '+ Rp ' . number_format($this->tambahan_harga, 0, ',', '.')
                : 'Gratis'
        );
    }

    // Static method: LevelPedas::urutHarga()->get()
    public static function urutHarga()
    {
        return static::orderBy('tambahan_harga')->orderBy('id_level');
    }

    public function detailKeranjangs()
    {
        return $this->hasMany(DetailKeranjang::class, 'id_level', 'id_level');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_level', 'id_level');
    }
}
