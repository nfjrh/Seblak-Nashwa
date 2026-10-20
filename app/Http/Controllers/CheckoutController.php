<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // 1. Menampilkan halaman checkout dengan data keranjang
    public function index()
    {
        // Ambil semua item keranjang tanpa filter user_id
        $keranjangItems = Keranjang::with(['menu', 'topping', 'levelPedas'])->get();

        $totalHarga = 0;
        foreach ($keranjangItems as $item) {
            $hargaMenu = $item->menu->harga ?? 0;
            $hargaTopping = $item->topping->harga ?? 0;
            $hargaLevel = $item->levelPedas->harga ?? 0;
            $totalHarga += ($hargaMenu + $hargaTopping + $hargaLevel) * $item->jumlah;
        }

        return view('pesanan.checkout', compact('keranjangItems', 'totalHarga'));
    }

    // 2. Memproses data checkout ke database
    public function process(Request $request)
    {
        $keranjangItems = Keranjang::all();

        if ($keranjangItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong!');
        }

        // Hitung total harga
        $totalHarga = 0;
        foreach ($keranjangItems as $item) {
            $hargaMenu = $item->menu->harga ?? 0;
            $hargaTopping = $item->topping->harga ?? 0;
            $hargaLevel = $item->levelPedas->harga ?? 0;
            $totalHarga += ($hargaMenu + $hargaTopping + $hargaLevel) * $item->jumlah;
        }

        // Simpan ke tabel Pesanan
        $pesanan = Pesanan::create([
            'user_id' => Auth::id() ?? 1,
            'total_harga' => $totalHarga,
            'status' => 'pending',
        ]);

        // Simpan ke tabel DetailPesanan
        foreach ($keranjangItems as $item) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $item->menu_id,
                'topping_id' => $item->topping_id,
                'level_pedas_id' => $item->level_pedas_id,
                'jumlah' => $item->jumlah,
                'subtotal' => (($item->menu->harga ?? 0) + ($item->topping->harga ?? 0) + ($item->levelPedas->harga ?? 0)) * $item->jumlah,
            ]);
        }

        // Simpan ke tabel Pembayaran
        Pembayaran::create([
            'pesanan_id' => $pesanan->id,
            'metode_pembayaran' => $request->input('metode_pembayaran', 'Transfer Bank'),
            'status_pembayaran' => 'belum_dibayar',
        ]);

        // Kosongkan keranjang belanja
        Keranjang::query()->delete();

        return redirect()->route('pesanan.riwayat')->with('success', 'Pesanan berhasil dibuat!');
    }
}