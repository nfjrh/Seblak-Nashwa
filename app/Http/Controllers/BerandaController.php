<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Topping;

class BerandaController extends Controller
{
    public function index()
    {
        // Empat seblak di landing page, urutannya sesuai desain.
        // Dipilih berdasarkan nama supaya data contoh milik anggota lain tidak ikut tampil.
        $namaSeblak = ['Seblak Komplit', 'Seblak Original', 'Seblak Ceker', 'Seblak Bakso Sosis'];

        $menus = Menu::with('kategori')
            ->tersedia()
            ->whereIn('nama_menu', $namaSeblak)
            ->get()
            ->sortBy(fn ($m) => array_search($m->nama_menu, $namaSeblak))
            ->values();

        // Cadangan: kalau nama-nama di atas belum ada (seeder belum dijalankan), ambil 4 seblak pertama.
        if ($menus->isEmpty()) {
            $menus = Menu::with('kategori')
                ->tersedia()
                ->whereHas('kategori', fn ($q) => $q->where('nama_kategori', 'Seblak'))
                ->orderBy('id_menu')
                ->limit(4)
                ->get();
        }

        // Minuman untuk bagian "teman makan pedas"
        $minuman = Menu::tersedia()->where('nama_menu', 'Es Teh Manis')->first()
            ?? Menu::tersedia()
                ->whereHas('kategori', fn ($q) => $q->where('nama_kategori', 'Minuman'))
                ->orderBy('id_menu')
                ->first();

        return view('beranda', [
            'menus'      => $menus,
            'minuman'    => $minuman,
            'hargaMulai' => $menus->min('harga'),
            'toppings'   => Topping::orderBy('nama_topping')->get(),
        ]);
    }
}
