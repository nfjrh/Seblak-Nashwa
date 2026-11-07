<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPesananController extends Controller
{
    // Constant: status berikutnya yang boleh dipilih dari tiap status
    private const TRANSISI = [
        Pesanan::STATUS_BARU     => [Pesanan::STATUS_DIPROSES, Pesanan::STATUS_BATAL],
        Pesanan::STATUS_DIPROSES => [Pesanan::STATUS_SIAP, Pesanan::STATUS_BATAL],
        Pesanan::STATUS_SIAP     => [Pesanan::STATUS_SELESAI],
    ];

    // Constructor: objek Pesanan disuntikkan otomatis oleh Laravel
    public function __construct(private Pesanan $pesanan)
    {
    }

    // Daftar pesanan masuk, bisa difilter: /admin/pesanan?status=baru
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = $status
            ? Pesanan::where('status_pesanan', $status)
            : $this->pesanan->newQuery();

        $pesanans = $query
            ->with(['user', 'pembayaran'])
            ->withCount('detailPesanans')
            ->orderByDesc('id_pesanan')
            ->get();

        $daftarStatus = [
            Pesanan::STATUS_BARU,
            Pesanan::STATUS_DIPROSES,
            Pesanan::STATUS_SIAP,
            Pesanan::STATUS_SELESAI,
            Pesanan::STATUS_BATAL,
        ];

        return view('admin.pesanan.index', compact('pesanans', 'daftarStatus', 'status'));
    }

    // Detail satu pesanan
    public function show(int $id)
    {
        $pesanan = $this->pesanan->newQuery()
            ->with([
                'user',
                'pembayaran',
                'detailPesanans.menu',
                'detailPesanans.levelPedas',
                'detailPesanans.toppings',
            ])
            ->findOrFail($id);

        $pilihanStatus = self::TRANSISI[$pesanan->status_pesanan] ?? [];

        return view('admin.pesanan.show', compact('pesanan', 'pilihanStatus'));
    }

    // Ubah status pesanan (hanya mengikuti alur TRANSISI)
    public function ubahStatus(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => 'required|string',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $boleh = self::TRANSISI[$pesanan->status_pesanan] ?? [];

        if (! in_array($data['status'], $boleh, true)) {
            return back()->with('galat', 'Perubahan status itu tidak diizinkan.');
        }

        $pesanan->update(['status_pesanan' => $data['status']]);

        return back()->with('status', 'Status pesanan diperbarui menjadi ' . $pesanan->label_status . '.');
    }

    // Verifikasi pembayaran: lunas atau ditolak
    public function verifikasiPembayaran(Request $request, int $id)
    {
        $data = $request->validate([
            'keputusan' => 'required|in:' . Pembayaran::STATUS_LUNAS . ',' . Pembayaran::STATUS_DITOLAK,
        ]);

        $pembayaran = Pembayaran::where('id_pesanan', $id)->firstOrFail();

        if ($pembayaran->status_pembayaran !== Pembayaran::STATUS_MENUNGGU) {
            return back()->with('galat', 'Pembayaran ini sudah diverifikasi.');
        }

        $pembayaran->update([
            'status_pembayaran'  => $data['keputusan'],
            'id_verifikator'     => Auth::id(),
            'tanggal_pembayaran' => $data['keputusan'] === Pembayaran::STATUS_LUNAS ? now() : null,
        ]);

        return back()->with('status', 'Pembayaran ditandai ' . $data['keputusan'] . '.');
    }
}
