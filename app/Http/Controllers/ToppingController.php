<?php

namespace App\Http\Controllers;

use App\Models\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    private function aturan(): array
    {
        return [
            'nama_topping' => 'required|string|max:100',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
        ];
    }

    public function index()
    {
        $toppings = Topping::orderBy('nama_topping')->get();
        return view('admin.topping.index', compact('toppings'));
    }

    public function create()
    {
        return view('admin.topping.create');
    }

    public function store(Request $request)
    {
        Topping::create($request->validate($this->aturan()));

        return redirect()->route('admin.topping.index')->with('success', 'Topping berhasil ditambahkan.');
    }

    public function edit(Topping $topping)
    {
        return view('admin.topping.edit', compact('topping'));
    }

    public function update(Request $request, Topping $topping)
    {
        $topping->update($request->validate($this->aturan()));

        return redirect()->route('admin.topping.index')->with('success', 'Topping berhasil diubah.');
    }

    public function destroy(Topping $topping)
    {
        try {
            $topping->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.topping.index')
                ->with('error', 'Topping tidak bisa dihapus karena sudah dipakai di keranjang atau pesanan.');
        }

        return redirect()->route('admin.topping.index')->with('success', 'Topping berhasil dihapus.');
    }
}
