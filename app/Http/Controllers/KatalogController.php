<?php

namespace App\Http\Controllers;

use App\Models\DetailKeranjang;
use App\Models\Kategori;
use App\Models\LevelPedas;
use App\Models\Menu;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KatalogController extends Controller
{
    // Constructor: objek Kategori disuntikkan otomatis oleh Laravel
    public function __construct(private Kategori $kategoriModel)
    {
    }

    public function index(Request $request) {
        $kategori = $this->kategoriModel->all();

        // Filter kategori dan pencarian nama: /katalog?kategori=1&q=ceker
        $menu = Menu::cariDanFilter($request->kategori, $request->q)->with('kategori')->get();

        // Ringkasan keranjang untuk panel di samping (kosong kalau belum masuk)
        $keranjangItems = Auth::check()
            ? DetailKeranjang::whereHas('keranjang', fn ($q) => $q->where('id_user', Auth::id()))
                ->with(['menu', 'levelPedas', 'toppings'])
                ->orderBy('id_detail_keranjang')
                ->get()
            : collect();

        $keranjangTotal = $keranjangItems->sum(fn ($item) => $item->subtotal());

        return view('katalog.index', compact('kategori', 'menu', 'keranjangItems', 'keranjangTotal'));
    }

    public function show(Menu $menu) {
        // Pilihan untuk form racik: level pedas dan topping
        $levels = LevelPedas::orderBy('id_level')->get();
        $toppings = Topping::orderBy('nama_topping')->get();

        return view('katalog.show', compact('menu', 'levels', 'toppings'));
    }
}