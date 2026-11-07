<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;

class KatalogController extends Controller {
    // Constructor: objek Kategori disuntikkan otomatis oleh Laravel
    public function __construct(private Kategori $kategoriModel) {

    }

    public function index(Request $request) {
        $kategori = $this->kategoriModel->all();

        // Filter kategori dan pencarian nama: /katalog?kategori=1&q=ceker
        $menu = Menu::cariDanFilter($request->kategori, $request->q)->get();

        return view('katalog.index', compact('kategori', 'menu'));
    }

    public function show(Menu $menu) {
        return view('katalog.show', compact('menu'));
    }
}