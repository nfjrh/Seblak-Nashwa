<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = false;

    protected $fillable = ['id_user', 'tanggal_dibuat'];

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailKeranjangs()
    // ===== Intan: tambahan fitur keranjang =====
    public function getTotalAttribute()
    {
        return $this->detailKeranjangs->sum(fn ($d) => $d->subtotal());
    }
    // ===== End Intan =====
    {
        return $this->hasMany(DetailKeranjang::class, 'id_keranjang', 'id_keranjang');
    }
}
