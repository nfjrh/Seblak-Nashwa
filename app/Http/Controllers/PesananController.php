<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    // Riwayat pesanan milik pelanggan yang sedang login
    public function riwayat()
    {
        $pesanans = Pesanan::where('id_user', Auth::id())
            ->with('pembayaran')
            ->withCount('detailPesanans')
            ->orderByDesc('id_pesanan')
            ->get();

        return view('pesanan.riwayat', compact('pesanans'));
    }

    // Detail dan status satu pesanan (hanya boleh milik sendiri)
    public function detail(int $id)
    {
        $pesanan = Pesanan::where('id_user', Auth::id())
            ->with(['detailPesanans.menu', 'detailPesanans.levelPedas', 'detailPesanans.toppings', 'pembayaran'])
            ->findOrFail($id);

        return view('pesanan.detail', compact('pesanan'));
    }
}
