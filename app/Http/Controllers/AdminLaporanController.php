<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminLaporanController extends Controller
{
    // Laporan penjualan sederhana. Filter: ?dari=2026-11-01 &sampai=2026-11-08 (bawaan: hari ini)
    public function index(Request $request)
    {
        $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ], [
            'sampai.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal awal.',
        ]);

        $dari = $request->query('dari', today()->toDateString());
        $sampai = $request->query('sampai', $dari);

        $pesanans = Pesanan::with('user')
            ->whereBetween('tanggal_pesanan', [Carbon::parse($dari)->startOfDay(), Carbon::parse($sampai)->endOfDay()])
            ->where('status_pesanan', '!=', Pesanan::STATUS_BATAL)
            ->orderByDesc('tanggal_pesanan')
            ->get();

        $jumlah = $pesanans->count();
        $penjualan = $pesanans->sum(fn ($p) => $p->subtotal_menu);

        $ringkasan = [
            'jumlah'    => $jumlah,
            'selesai'   => $pesanans->where('status_pesanan', Pesanan::STATUS_SELESAI)->count(),
            'penjualan' => $penjualan,
            'rataRata'  => $jumlah > 0 ? $penjualan / $jumlah : 0,
            'layanan'   => $pesanans->sum('biaya_layanan'),
            'ongkir'    => $pesanans->sum('ongkir'),
            'tagihan'   => $pesanans->sum('total_harga'),
        ];

        // Penjualan menu per jam (jam layanan 10.00 sampai 21.00)
        $penjualanPerJam = array_fill_keys(range(10, 21), 0.0);
        foreach ($pesanans as $p) {
            $jam = (int) $p->tanggal_pesanan->format('G');
            if (isset($penjualanPerJam[$jam])) {
                $penjualanPerJam[$jam] += $p->subtotal_menu;
            }
        }

        // Menu terlaris: dijumlahkan dari rincian pesanan pada periode ini
        $menuTerlaris = DetailPesanan::selectRaw('id_menu, SUM(jumlah) as porsi, SUM(subtotal) as nilai')
            ->whereIn('id_pesanan', $pesanans->pluck('id_pesanan'))
            ->groupBy('id_menu')
            ->orderByDesc('nilai')
            ->with('menu')
            ->limit(5)
            ->get();

        return view('admin.laporan.index', [
            'dari'            => $dari,
            'sampai'          => $sampai,
            'ringkasan'       => $ringkasan,
            'penjualanPerJam' => $penjualanPerJam,
            'menuTerlaris'    => $menuTerlaris,
            'rincian'         => $pesanans->take(15),
        ]);
    }
}
