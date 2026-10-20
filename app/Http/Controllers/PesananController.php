<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    // Menampilkan daftar riwayat pesanan
    public function riwayat()
    {
        $pesanans = Pesanan::with(['pembayaran', 'detailPesanan'])->get();

        return view('pesanan.riwayat', compact('pesanans'));
    }

    // Menampilkan detail dari satu pesanan tertentu
    public function detail($id)
    {
        $pesanan = Pesanan::with([
            'detailPesanan.menu', 
            'detailPesanan.topping', 
            'detailPesanan.levelPedas', 
            'pembayaran'
        ])
        ->findOrFail($id);

        return view('pesanan.detail', compact('pesanan'));
    }
}