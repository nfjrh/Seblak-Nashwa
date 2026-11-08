<?php

// Controller Checkout & Pesanan Seblak Nashwa

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

    // Constructor: Laravel otomatis menyuntikkan objek DetailKeranjang
    public function __construct(private DetailKeranjang $keranjangItem)
    {
    }

    private function itemKeranjang()
    {
        return $this->keranjangItem->newQuery()
            ->whereHas('keranjang', fn ($q) => $q->where('id_user', Auth::id()))
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

        // Biaya tiap cara pengambilan, supaya halaman bisa menghitung total saat pilihan berubah
        $biaya = [
            Pesanan::AMBIL => Pesanan::hitungBiaya(Pesanan::AMBIL),
            Pesanan::ANTAR => Pesanan::hitungBiaya(Pesanan::ANTAR),
        ];

        return view('pesanan.checkout', compact('items', 'total', 'metodeBayar', 'biaya'));
    }

    // 2. Simpan pesanan
    public function process(Request $request)
    {
        $data = $request->validate([
            'metode_pengambilan' => 'required|in:' . Pesanan::AMBIL . ',' . Pesanan::ANTAR,
            'nama_penerima'      => 'required|string|max:100',
            'nomor_penerima'     => ['required', 'regex:/^08[0-9]{8,12}$/'],
            'alamat'             => 'required_if:metode_pengambilan,' . Pesanan::ANTAR . '|nullable|string|max:500',
            'detail_alamat'      => 'nullable|string|max:200',
            'catatan'            => 'nullable|string|max:500',
            'metode_pembayaran'  => 'required|in:' . implode(',', array_keys(self::METODE_BAYAR)),
        ], [
            'nama_penerima.required'  => 'Isi nama penerima dulu.',
            'nomor_penerima.required' => 'Isi nomor WhatsApp penerima dulu.',
            'nomor_penerima.regex'    => 'Nomor WhatsApp harus diawali 08 dan 10 sampai 14 digit.',
            'alamat.required_if'      => 'Isi alamat pengantaran dulu.',
        ]);

        $items = $this->itemKeranjang();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('status', 'Keranjang masih kosong.');
        }

        $antar = $data['metode_pengambilan'] === Pesanan::ANTAR;
        $biaya = Pesanan::hitungBiaya($data['metode_pengambilan']);
        $total = $items->sum(fn ($item) => $item->subtotal()) + $biaya['layanan'] + $biaya['ongkir'];

        $pesanan = DB::transaction(function () use ($data, $items, $total, $biaya, $antar) {
            $pesanan = Pesanan::create([
                'id_user'            => Auth::id(),
                'total_harga'        => $total,
                'biaya_layanan'      => $biaya['layanan'],
                'ongkir'             => $biaya['ongkir'],
                'metode_pengambilan' => $data['metode_pengambilan'],
                'nama_penerima'      => $data['nama_penerima'],
                'nomor_penerima'     => $data['nomor_penerima'],
                'alamat'             => $antar ? $data['alamat'] : null,
                'detail_alamat'      => $antar ? ($data['detail_alamat'] ?? null) : null,
                'catatan'            => $data['catatan'] ?? null,
                'status_pesanan'     => Pesanan::STATUS_BARU,
            ]);

            foreach ($items as $item) {
                $detail = DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu'    => $item->id_menu,
                    'id_level'   => $item->id_level,
                    'jumlah'     => $item->jumlah,
                    'catatan'    => $item->catatan,
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
                'status_pembayaran' => Pembayaran::STATUS_MENUNGGU,
            ]);

            // Kosongkan keranjang pelanggan ini
            DetailKeranjang::whereIn('id_detail_keranjang', $items->pluck('id_detail_keranjang'))->delete();

            return $pesanan;
        });

        return redirect()->route('pesanan.detail', $pesanan->id_pesanan)
            ->with('status', 'Pesananmu sudah kami terima. Terima kasih!');
    }
}
