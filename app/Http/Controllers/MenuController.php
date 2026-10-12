<?php
 
namespace App\Http\Controllers;
 
use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::with('kategori')->get();
        return view('menu.index', compact('menu'));
    }
 
    public function create()
    {
        $kategori = Kategori::all();
        return view('menu.create', compact('kategori'));
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_menu'   => 'required|string|max:150',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|max:2048',
            'status'      => 'required|in:tersedia,habis',
        ]);
 
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        }
 
        Menu::create($data);
 
        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }
 
    public function edit(Menu $menu)
    {
        $kategori = Kategori::all();
        return view('menu.edit', compact('menu', 'kategori'));
    }
 
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_menu'   => 'required|string|max:150',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|max:2048',
            'status'      => 'required|in:tersedia,habis',
        ]);
 
        if ($request->hasFile('gambar')) {
            if ($menu->gambar) {
                Storage::disk('public')->delete($menu->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        }
 
        $menu->update($data);
 
        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diubah.');
    }
 
    public function destroy(Menu $menu)
    {
        if ($menu->gambar) {
            Storage::disk('public')->delete($menu->gambar);
        }
 
        $menu->delete();
 
        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}