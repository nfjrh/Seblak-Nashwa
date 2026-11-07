<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model {
    // Constant: panjang maksimal nama kategori (dipakai di validasi controller)
    const NAMA_MAKS = 100;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = ['nama_kategori'];

    // Mutator: nama kategori rapi
    protected function namaKategori(): Attribute {
        return Attribute::make(
            set: fn ($nilai) => ucwords(strtolower(trim($nilai)))
        );
    }

    public function menus() {
        return $this->hasMany(Menu::class, 'id_kategori', 'id_kategori');
    }
}