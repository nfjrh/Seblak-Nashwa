<?php

namespace App\Http\Controllers;

use App\Models\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    public function index()
    {
        $toppings = Topping::all();
        return view('topping.index', compact('toppings'));
    }

    public function create()
    {
        return view('topping.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_topping' => 'required|string|max:255',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
        ]);

        Topping::create($data);

        return redirect()->route('topping.index')
            ->with('success', 'Topping berhasil ditambahkan.');
    }

    public function edit(Topping $topping)
    {
        return view('topping.edit', compact('topping'));
    }

    public function update(Request $request, Topping $topping)
    {
        $data = $request->validate([
            'nama_topping' => 'required|string|max:255',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
        ]);

        $topping->update($data);

        return redirect()->route('topping.index')
            ->with('success', 'Topping berhasil diubah.');
    }

    public function destroy(Topping $topping)
    {
        $topping->delete();

        return redirect()->route('topping.index')
            ->with('success', 'Topping berhasil dihapus.');
    }
}