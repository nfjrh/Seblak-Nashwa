<?php

namespace App\Http\Controllers;

use App\Models\DetailKeranjang;
use App\Models\Keranjang;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /** Item keranjang milik pelanggan yang sedang login. */
    private function itemMilikSaya()
    {
        return DetailKeranjang::whereHas('keranjang', fn ($q) => $q->where('id_user', Auth::id()));
    }

    public function index()
    {
        $items = $this->itemMilikSaya()
            ->with(['menu', 'levelPedas', 'toppings'])
            ->orderBy('id_detail_keranjang')
            ->get();

        $total = $items->sum(fn ($item) => $item->subtotal());

        return view('keranjang.index', compact('items', 'total'));
    }

    public function tambah(Request $request)
    {
        $data = $request->validate([
            'id_menu'    => 'required|exists:menu,id_menu',
            'id_level'   => 'required|exists:level_pedas,id_level',
            'topping'    => 'nullable|array',
            'topping.*'  => 'exists:topping,id_topping',
            'jumlah'     => 'required|integer|min:1|max:20',
        ], [
            'id_level.required' => 'Pilih level pedasnya dulu.',
        ]);

        $menu = Menu::findOrFail($data['id_menu']);
        if ($menu->status !== 'tersedia') {
            return back()->withErrors(['id_menu' => 'Menu ini sedang habis.']);
        }

        $toppingIds = collect($data['topping'] ?? [])->map(fn ($v) => (int) $v)->unique()->sort()->values()->all();

        $keranjang = Keranjang::firstOrCreate(['id_user' => Auth::id()]);

        // Kalau menu, level, dan topping-nya sama persis, cukup tambah jumlahnya.
        $sama = $keranjang->detailKeranjangs()
            ->where('id_menu', $menu->id_menu)
            ->where('id_level', $data['id_level'])
            ->with('toppings')
            ->get()
            ->first(fn ($d) => $d->toppings->pluck('id_topping')->map(fn ($v) => (int) $v)->sort()->values()->all() === $toppingIds);

        if ($sama) {
            $sama->update(['jumlah' => min(20, $sama->jumlah + $data['jumlah'])]);
        } else {
            $item = DetailKeranjang::create([
                'id_keranjang' => $keranjang->id_keranjang,
                'id_menu'      => $menu->id_menu,
                'id_level'     => $data['id_level'],
                'jumlah'       => $data['jumlah'],
            ]);
            $item->toppings()->sync($toppingIds);
        }

        return redirect()->route('keranjang.index')->with('status', $menu->nama_menu . ' masuk ke keranjang.');
    }

    public function ubah(Request $request, int $id)
    {
        $data = $request->validate(['jumlah' => 'required|integer|min:1|max:20']);

        $this->itemMilikSaya()->findOrFail($id)->update(['jumlah' => $data['jumlah']]);

        return redirect()->route('keranjang.index');
    }

    public function hapus(int $id)
    {
        $this->itemMilikSaya()->findOrFail($id)->delete();

        return redirect()->route('keranjang.index')->with('status', 'Item dihapus dari keranjang.');
    }
}
