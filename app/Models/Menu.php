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
     * URL foto menu. Mendukung dua cara penyimpanan:
     * 1. Foto upload dari form admin, tersimpan di storage (contoh: menu/abc.jpg),
     *    dan tampil lewat folder public/storage (butuh: php artisan storage:link).
     * 2. Foto manual di folder public (contoh: images/menu/seblak.jpg).
     * Kalau file tidak ditemukan, hasilnya null dan tampilan memakai gambar pengganti.
     */
    public function fotoUrl(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        $path = ltrim($this->gambar, '/');

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        if (file_exists(public_path('storage/' . $path))) {
            return asset('storage/' . $path);
        }

        return null;
    }
}
