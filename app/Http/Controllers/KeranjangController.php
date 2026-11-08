<?php

namespace App\Http\Controllers;

use App\Models\DetailKeranjang;
use App\Models\Keranjang;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // Constructor: Laravel otomatis menyuntikkan objek DetailKeranjang
    public function __construct(private DetailKeranjang $detail)
    {
    }

    /** Item keranjang milik pelanggan yang sedang login. */
    private function itemMilikSaya()
    {
        return $this->detail->newQuery()
            ->whereHas('keranjang', fn ($q) => $q->where('id_user', Auth::id()));
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
            'id_level'   => 'nullable|exists:level_pedas,id_level',
            'topping'    => 'nullable|array',
            'topping.*'  => 'exists:topping,id_topping',
            'jumlah'     => 'required|integer|min:' . DetailKeranjang::JUMLAH_MIN . '|max:' . DetailKeranjang::JUMLAH_MAKS,
            'catatan'    => 'nullable|string|max:' . DetailKeranjang::CATATAN_MAKS,
        ]);

        $menu = Menu::with('kategori')->findOrFail($data['id_menu']);
        if ($menu->status !== Menu::STATUS_TERSEDIA) {
            return back()->withErrors(['id_menu' => 'Menu ini sedang habis.']);
        }

        // Seblak wajib memilih level pedas dan boleh memakai topping.
        // Menu lain (minuman, topping) langsung dipesan tanpa level dan tanpa topping.
        if ($menu->bisaDiracik()) {
            if (empty($data['id_level'])) {
                return back()->withErrors(['id_level' => 'Pilih level pedasnya dulu.'])->withInput();
            }
            $idLevel = (int) $data['id_level'];
            $toppingIds = collect($data['topping'] ?? [])->map(fn ($v) => (int) $v)->unique()->sort()->values()->all();
        } else {
            $idLevel = null;
            $toppingIds = [];
        }

        $catatan = trim((string) ($data['catatan'] ?? '')) ?: null;

        $keranjang = Keranjang::milikUser(Auth::id());

        // Kalau menu, level, topping, dan catatannya sama persis, cukup tambah jumlahnya.
        $sama = $keranjang->detailKeranjangs()
            ->where('id_menu', $menu->id_menu)
            ->where('id_level', $idLevel)
            ->where('catatan', $catatan)
            ->with('toppings')
            ->get()
            ->first(fn ($d) => $d->toppings->pluck('id_topping')->map(fn ($v) => (int) $v)->sort()->values()->all() === $toppingIds);

        if ($sama) {
            $sama->update(['jumlah' => $sama->jumlah + $data['jumlah']]); // batas maksimal dijaga mutator
        } else {
            $item = DetailKeranjang::create([
                'id_keranjang' => $keranjang->id_keranjang,
                'id_menu'      => $menu->id_menu,
                'id_level'     => $idLevel,
                'jumlah'       => $data['jumlah'],
                'catatan'      => $catatan,
            ]);
            $item->toppings()->sync($toppingIds);
        }

        return redirect()->route('keranjang.index')->with('status', $menu->nama_menu . ' masuk ke keranjang.');
    }

    public function ubah(Request $request, int $id)
    {
        $data = $request->validate([
            'jumlah' => 'required|integer|min:' . DetailKeranjang::JUMLAH_MIN . '|max:' . DetailKeranjang::JUMLAH_MAKS,
        ]);

        $this->itemMilikSaya()->findOrFail($id)->update(['jumlah' => $data['jumlah']]);

        return redirect()->route('keranjang.index');
    }

    public function hapus(int $id)
    {
        $this->itemMilikSaya()->findOrFail($id)->delete();

        return redirect()->route('keranjang.index')->with('status', 'Item dihapus dari keranjang.');
    }
}
