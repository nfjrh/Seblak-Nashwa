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

    public function tambah(Request $request) {
        // Ambil data menu terlebih dahulu untuk mengecek kategorinya
        $menu = Menu::with('kategori')->findOrFail($request->id_menu);
        if ($menu->status !== 'tersedia') {
            return back()->withErrors(['id_menu' => 'Menu ini sedang habis.']);
        }

        // Cek apakah menu ini adalah kategori Seblak
        $isSeblak = $menu->kategori && strtolower($menu->kategori->nama_kategori) === 'seblak';

        // Validasi dinamis: level pedas wajib jika seblak, nullable jika bukan seblak
        $data = $request->validate([
            'id_menu'    => 'required|exists:menu,id_menu',
            'id_level'   => $isSeblak ? 'required|exists:level_pedas,id_level' : 'nullable',
            'topping'    => 'nullable|array',
            'topping.*'  => 'exists:topping,id_topping',
            'jumlah'     => 'required|integer|min:' . DetailKeranjang::JUMLAH_MIN . '|max:' . DetailKeranjang::JUMLAH_MAKS,
        ], [
            'id_level.required' => 'Pilih level pedasnya dulu.',
        ]);

        $toppingIds = collect($data['topping'] ?? [])->map(fn ($v) => (int) $v)->unique()->sort()->values()->all();

        $keranjang = Keranjang::milikUser(Auth::id());

        // Kalau menu, level, dan topping-nya sama persis, cukup tambah jumlahnya.
        $sama = $keranjang->detailKeranjangs()
            ->where('id_menu', $menu->id_menu)
            ->where('id_level', $data['id_level'] ?? null)
            ->with('toppings')
            ->get()
            ->first(fn ($d) => $d->toppings->pluck('id_topping')->map(fn ($v) => (int) $v)->sort()->values()->all() === $toppingIds);

        if ($sama) {
            $sama->update(['jumlah' => $sama->jumlah + $data['jumlah']]); // batas maksimal dijaga mutator
        } else {
            $item = DetailKeranjang::create([
                'id_keranjang' => $keranjang->id_keranjang,
                'id_menu'      => $menu->id_menu,
                'id_level'     => $data['id_level'] ?? null,
                'jumlah'       => $data['jumlah'],
            ]);
            $item->toppings()->sync($toppingIds);
        }

        return redirect()->route('keranjang.index')->with('status', $menu->nama_menu . ' masuk ke keranjang.');
    }

    public function hapus($id)
    {
        // Cari item keranjang berdasarkan ID dan pastikan milik user yang sedang login
        $item = $this->itemMilikSaya()->where('id_detail_keranjang', $id)->firstOrFail();
        
        // Hapus relasi topping terlebih dahulu lalu hapus item detail keranjangnya
        $item->toppings()->detach();
        $item->delete();

        return redirect()->route('keranjang.index')->with('status', 'Item berhasil dihapus dari keranjang.');
    }
}