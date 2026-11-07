<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    // Constant: role pengguna (menggantikan teks 'admin' / 'pembeli')
    const ROLE_ADMIN = 'admin';
    const ROLE_PEMBELI = 'pembeli';

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

    // Mutator: nama dirapikan (spasi ganda dibuang, huruf awal besar)
    protected function nama(): Attribute
    {
        return Attribute::make(
            set: fn ($nilai) => Str::title(preg_replace('/\s+/', ' ', trim($nilai)))
        );
    }

    // Accessor: $user->nama_depan
    protected function namaDepan(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::of($this->nama)->before(' ')->toString()
        );
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPembeli(): bool
    {
        return $this->role === self::ROLE_PEMBELI;
    }

    // Static method: User::cariByEmail('a@b.com')
    public static function cariByEmail(string $email): ?self
    {
        return static::where('email', Str::lower($email))->first();
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
