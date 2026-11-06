<?php

namespace App\Http\Controllers;

use App\Models\DetailKeranjang;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private const METODE_BAYAR = [
        'transfer' => 'Transfer Bank',
        'qris'     => 'QRIS / E-Wallet',
        'tunai'    => 'Bayar di Tempat',
    ];

    private function itemKeranjang()
    {
        return DetailKeranjang::whereHas('keranjang', fn ($q) => $q->where('id_user', Auth::id()))
            ->with(['menu', 'levelPedas', 'toppings'])
            ->orderBy('id_detail_keranjang')
            ->get();
    }

    // 1. Halaman checkout
    public function index()
    {
        $items = $this->itemKeranjang();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('status', 'Keranjang masih kosong, pilih menu dulu ya.');
        }

        $total = $items->sum(fn ($item) => $item->subtotal());
        $metodeBayar = self::METODE_BAYAR;

        return view('pesanan.checkout', compact('items', 'total', 'metodeBayar'));
    }

    // 2. Simpan pesanan
    public function process(Request $request)
    {
        $data = $request->validate([
            'metode_pengambilan' => 'required|in:ambil,antar',
            'alamat'             => 'required_if:metode_pengambilan,antar|nullable|string|max:500',
            'catatan'            => 'nullable|string|max:500',
            'metode_pembayaran'  => 'required|in:' . implode(',', array_keys(self::METODE_BAYAR)),
        ], [
            'alamat.required_if' => 'Isi alamat pengantaran dulu.',
        ]);

        $items = $this->itemKeranjang();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('status', 'Keranjang masih kosong.');
        }

        $total = $items->sum(fn ($item) => $item->subtotal());

        $pesanan = DB::transaction(function () use ($data, $items, $total) {
            $pesanan = Pesanan::create([
                'id_user'            => Auth::id(),
                'total_harga'        => $total,
                'metode_pengambilan' => $data['metode_pengambilan'],
                'alamat'             => $data['metode_pengambilan'] === 'antar' ? $data['alamat'] : null,
                'catatan'            => $data['catatan'] ?? null,
                'status_pesanan'     => 'baru',
            ]);

            foreach ($items as $item) {
                $detail = DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu'    => $item->id_menu,
                    'id_level'   => $item->id_level,
                    'jumlah'     => $item->jumlah,
                    'harga'      => $item->hargaSatuan(),
                    'subtotal'   => $item->subtotal(),
                ]);

                // Harga topping disimpan di pesanan supaya tidak berubah kalau harga topping diganti nanti.
                foreach ($item->toppings as $topping) {
                    $detail->toppings()->attach($topping->id_topping, ['harga' => $topping->harga]);
                }
            }

            Pembayaran::create([
                'id_pesanan'        => $pesanan->id_pesanan,
                'metode_pembayaran' => self::METODE_BAYAR[$data['metode_pembayaran']],
                'jumlah_pembayaran' => $total,
                'status_pembayaran' => 'menunggu',
            ]);

            // Kosongkan keranjang pelanggan ini
            DetailKeranjang::whereIn('id_detail_keranjang', $items->pluck('id_detail_keranjang'))->delete();

            return $pesanan;
        });

        return redirect()->route('pesanan.detail', $pesanan->id_pesanan)
            ->with('status', 'Pesananmu sudah kami terima. Terima kasih!');
    }
}
