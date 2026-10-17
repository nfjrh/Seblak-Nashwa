<?php

namespace App\Http\Controllers;

use App\Models\LevelPedas;
use App\Models\Menu;
use App\Models\Topping;

class BerandaController extends Controller
{
    public function index()
    {
        // 4 menu seblak yang tersedia
        $menus = Menu::with('kategori')
            ->tersedia()
            ->whereHas('kategori', fn ($q) => $q->where('nama_kategori', 'Seblak'))
            ->orderBy('id_menu')
            ->limit(4)
            ->get();

        // satu minuman untuk bagian "teman makan pedas"
        $minuman = Menu::tersedia()
            ->whereHas('kategori', fn ($q) => $q->where('nama_kategori', 'Minuman'))
            ->orderBy('id_menu')
            ->first();

        return view('beranda', [
            'menus'      => $menus,
            'minuman'    => $minuman,
            'hargaMulai' => $menus->min('harga'),
            'levels'     => LevelPedas::orderBy('id_level')->get(),
            'toppings'   => Topping::orderBy('nama_topping')->get(),
        ]);
    }
}
