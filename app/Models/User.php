<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'nomor_hp',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relasi: satu user punya banyak keranjang dan banyak pesanan
    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'id_user', 'id_user');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_user', 'id_user');
    }

    // Pembayaran yang diverifikasi oleh user ini (kasir/admin)
    public function pembayaranDiverifikasi()
    {
        return $this->hasMany(Pembayaran::class, 'id_verifikator', 'id_user');
    }
}
