<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['nama' => 'Admin Seblak', 'email' => 'admin@seblak.test', 'nomor_hp' => '081234567890', 'password' => Hash::make('password'), 'role' => 'admin'],
            ['nama' => 'Pembeli Contoh', 'email' => 'pembeli@seblak.test', 'nomor_hp' => '081298765432', 'password' => Hash::make('password'), 'role' => 'pembeli'],
        ]);

        DB::table('kategori')->insert([
            ['nama_kategori' => 'Seblak'],
            ['nama_kategori' => 'Minuman'],
        ]);

        DB::table('level_pedas')->insert([
            ['nama_level' => 'Level 0 (Tidak Pedas)', 'tambahan_harga' => 0],
            ['nama_level' => 'Level 1 (Sedang)', 'tambahan_harga' => 0],
            ['nama_level' => 'Level 2 (Pedas)', 'tambahan_harga' => 1000],
            ['nama_level' => 'Level 3 (Sangat Pedas)', 'tambahan_harga' => 2000],
        ]);

        DB::table('topping')->insert([
            ['nama_topping' => 'Ceker', 'harga' => 3000, 'stok' => 50],
            ['nama_topping' => 'Bakso', 'harga' => 2000, 'stok' => 50],
            ['nama_topping' => 'Sosis', 'harga' => 2000, 'stok' => 50],
            ['nama_topping' => 'Telur', 'harga' => 3000, 'stok' => 50],
            ['nama_topping' => 'Kerupuk', 'harga' => 1000, 'stok' => 50],
        ]);

        DB::table('menu')->insert([
            ['id_kategori' => 1, 'nama_menu' => 'Seblak Original', 'deskripsi' => 'Seblak kuah khas dengan kerupuk dan sayur', 'harga' => 15000, 'status' => 'tersedia'],
            ['id_kategori' => 1, 'nama_menu' => 'Seblak Kering', 'deskripsi' => 'Seblak tanpa kuah, bumbu pekat', 'harga' => 15000, 'status' => 'tersedia'],
            ['id_kategori' => 2, 'nama_menu' => 'Es Teh', 'deskripsi' => 'Es teh manis', 'harga' => 5000, 'status' => 'tersedia'],
        ]);
    }
}