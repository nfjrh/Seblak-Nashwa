<?php
 
namespace App\Http\Controllers;
 
use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;
 
class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();
 
        $menu = Menu::when($request->kategori, function ($query, $id) {
            $query->where('id_kategori', $id);
        })->get();
 
        return view('katalog.index', compact('kategori', 'menu'));
    }
 
    public function show(Menu $menu)
    {
        return view('katalog.show', compact('menu'));
    }
}
