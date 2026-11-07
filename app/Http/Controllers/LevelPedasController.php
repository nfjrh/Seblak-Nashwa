<?php

namespace App\Http\Controllers;

use App\Models\LevelPedas;
use Illuminate\Http\Request;

class LevelPedasController extends Controller
{
    // Constructor: objek LevelPedas disuntikkan otomatis oleh Laravel
    public function __construct(private LevelPedas $model)
    {
    }

    private function aturan(): array
    {
        return [
            'nama_level'     => 'required|string|max:100',
            'tambahan_harga' => 'required|numeric|min:0|max:' . LevelPedas::TAMBAHAN_HARGA_MAKS,
        ];
    }

    public function index(Request $request)
    {
        // Urut harga: /admin/level?urut=harga
        $query = $request->query('urut') === 'harga'
            ? LevelPedas::urutHarga()
            : $this->model->newQuery()->orderBy('id_level');

        $levels = $query->get();
        return view('admin.level.index', compact('levels'));
    }

    public function create()
    {
        return view('admin.level.create');
    }

    public function store(Request $request)
    {
        LevelPedas::create($request->validate($this->aturan()));

        return redirect()->route('admin.level.index')->with('success', 'Level pedas berhasil ditambahkan.');
    }

    public function edit(LevelPedas $level)
    {
        return view('admin.level.edit', compact('level'));
    }

    public function update(Request $request, LevelPedas $level)
    {
        $level->update($request->validate($this->aturan()));

        return redirect()->route('admin.level.index')->with('success', 'Level pedas berhasil diubah.');
    }

    public function destroy(LevelPedas $level)
    {
        try {
            $level->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.level.index')
                ->with('error', 'Level pedas tidak bisa dihapus karena sudah dipakai di keranjang atau pesanan.');
        }

        return redirect()->route('admin.level.index')->with('success', 'Level pedas berhasil dihapus.');
    }
}
