<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori', 'nama_menu', 'deskripsi', 'harga', 'gambar', 'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function detailKeranjangs()
    {
        return $this->hasMany(DetailKeranjang::class, 'id_menu', 'id_menu');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_menu', 'id_menu');
    }

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('status', 'tersedia');
    }

    /**
     * URL foto menu. Kolom `gambar` berisi path relatif dari folder public,
     * contoh: images/menu/seblak-komplit.jpg
     * Kalau file belum ada, hasilnya null dan tampilan memakai gambar pengganti.
     */
    public function fotoUrl(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        $path = ltrim($this->gambar, '/');

        return file_exists(public_path($path)) ? asset($path) : null;
    }
}
