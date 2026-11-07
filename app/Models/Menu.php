<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
    // Constant: status menu 
    const STATUS_TERSEDIA = 'tersedia';
    const STATUS_HABIS = 'habis';

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori', 'nama_menu', 'deskripsi', 'harga', 'gambar', 'status',
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function detailKeranjangs() {
        return $this->hasMany(DetailKeranjang::class, 'id_menu', 'id_menu');
    }

    public function detailPesanans() {
        return $this->hasMany(DetailPesanan::class, 'id_menu', 'id_menu');
    }

    public function scopeTersedia(Builder $query): Builder {
        return $query->where('status', self::STATUS_TERSEDIA);
    }

    // Mutator: nama menu rapi
    protected function namaMenu(): Attribute {
        return Attribute::make(
            set: fn ($nilai) => ucwords(strtolower(trim($nilai)))
        );
    }

    // Accessor: $menu->harga_rupiah
    protected function hargaRupiah(): Attribute {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->harga, 0, ',', '.')
        );
    }

    // Hanya menu kategori Seblak yang bisa diracik (pilih level pedas dan topping).
    // Minuman dan topping langsung dipesan tanpa level pedas.
    public function bisaDiracik(): bool
    {
        return $this->kategori?->nama_kategori === Kategori::SEBLAK;
    }

    // Static method: Menu::cariDanFilter($idKategori, $kata)->get()
    public static function cariDanFilter($idKategori = null, ?string $kata = null)
    {
        return static::query()
            ->when($idKategori, fn ($q, $id) => $q->where('id_kategori', $id))
            ->when($kata, fn ($q, $k) => $q->where('nama_menu', 'like', '%' . $k . '%'));
    }

    public function fotoUrl(): ?string {
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