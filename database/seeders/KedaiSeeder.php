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
| Harga menu di bawah hanya contoh dari desain, silakan sesuaikan dengan Ibu Ayu.
*/
class KedaiSeeder extends Seeder
{
    public function run(): void
    {
        $seblak  = Kategori::firstOrCreate(['nama_kategori' => 'Seblak']);
        $minuman = Kategori::firstOrCreate(['nama_kategori' => 'Minuman']);

        // Level pedas 0 sampai 5 (tambahan harga 0 sampai ada keputusan dari pemilik)
        for ($i = 0; $i <= 5; $i++) {
            LevelPedas::updateOrCreate(
                ['nama_level' => 'Level ' . $i],
                ['tambahan_harga' => 0]
            );
        }

        // Topping (harga dari hasil wawancara + contoh tambahan)
        $toppings = [
            ['Sayap',    5000, 50],
            ['Ceker',    5000, 50],
            ['Seafood',  3000, 50],
            ['Bakso',    3000, 50],
            ['Sosis',    3000, 50],
            ['Telur',    3000, 50],
            ['Mozzarella', 4000, 50],
        ];

        foreach ($toppings as [$nama, $harga, $stok]) {
            Topping::updateOrCreate(
                ['nama_topping' => $nama],
                ['harga' => $harga, 'stok' => $stok]
            );
        }

        // Menu
        $menus = [
            [$seblak,  'Seblak Komplit',     'Kerupuk, makaroni, sayap, ceker, dan topping lengkap dalam satu mangkuk.', 18000],
            [$seblak,  'Seblak Original',    'Kerupuk, makaroni, dan sayuran dengan bumbu kencur khas rumahan.',        12000],
            [$seblak,  'Seblak Ceker',       'Seblak dengan ceker empuk yang meresap bumbu.',                           16000],
            [$seblak,  'Seblak Bakso Sosis', 'Bakso dan sosis di atas kuah seblak yang gurih pedas.',                   15000],
            [$minuman, 'Es Teh Manis',       'Segar untuk meredakan pedas.',                                             5000],
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
