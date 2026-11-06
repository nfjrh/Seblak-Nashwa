<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\LevelPedas;
use App\Models\Menu;
use App\Models\Topping;
use Illuminate\Database\Seeder;

/*
| Data awal untuk landing page. Aman dijalankan berulang kali (updateOrCreate).
| Jalankan:  php artisan db:seed --class=KedaiSeeder
| Harga dan deskripsi mengikuti desain landing page. Sesuaikan dengan pemilik kedai bila perlu.
*/
class KedaiSeeder extends Seeder
{
    public function run(): void
    {
        $seblak  = Kategori::firstOrCreate(['nama_kategori' => 'Seblak']);
        $minuman = Kategori::firstOrCreate(['nama_kategori' => 'Minuman']);

        // Level pedas 0 sampai 5.
        // Hapus dulu level contoh dari DatabaseSeeder (misalnya "Level 0 (Tidak Pedas)")
        // selama belum dipakai di keranjang atau pesanan, supaya tidak dobel.
        $levelValid = array_map(fn ($i) => 'Level ' . $i, range(0, 5));
        LevelPedas::whereNotIn('nama_level', $levelValid)
            ->whereDoesntHave('detailKeranjangs')
            ->whereDoesntHave('detailPesanans')
            ->delete();

        for ($i = 0; $i <= 5; $i++) {
            LevelPedas::updateOrCreate(
                ['nama_level' => 'Level ' . $i],
                ['tambahan_harga' => 0]
            );
        }

        // Topping
        $toppings = [
            ['Sayap',      5000, 50],
            ['Ceker',      3000, 50],
            ['Seafood',    3000, 50],
            ['Bakso',      3000, 50],
            ['Sosis',      3000, 50],
            ['Telur',      3000, 50],
            ['Mozzarella', 5000, 50],
        ];

        foreach ($toppings as [$nama, $harga, $stok]) {
            Topping::updateOrCreate(
                ['nama_topping' => $nama],
                ['harga' => $harga, 'stok' => $stok]
            );
        }

        // Menu
        $menus = [
            [$seblak,  'Seblak Komplit',     'Kerupuk, mi, telur, bakso & sosis.',      18000],
            [$seblak,  'Seblak Original',    'Kerupuk, makaroni, telur & sayur.',       12000],
            [$seblak,  'Seblak Ceker',       'Cekernya empuk, kerupuk, telur & sayur.', 16000],
            [$seblak,  'Seblak Bakso Sosis', 'Bakso, sosis, kerupuk & telur.',          15000],
            [$minuman, 'Es Teh Manis',       'Teh segar, teman makan pedas.',            5000],
        ];

        foreach ($menus as [$kategori, $nama, $deskripsi, $harga]) {
            Menu::updateOrCreate(
                ['nama_menu' => $nama],
                [
                    'id_kategori' => $kategori->id_kategori,
                    'deskripsi'   => $deskripsi,
                    'harga'       => $harga,
                    'status'      => 'tersedia',
                ]
            );
        }
    }
}
