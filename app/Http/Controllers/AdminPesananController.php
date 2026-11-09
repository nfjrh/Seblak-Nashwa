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

    // Daftar pesanan masuk. Filter: ?status=baru &q=nama-atau-nomor &dari=2026-11-01 &sampai=2026-11-08
    public function index(Request $request)
    {
        $status = $request->query('status');
        $kataKunci = trim((string) $request->query('q'));

        $query = $this->pesanan->newQuery();

        if ($status) {
            $query->where('status_pesanan', $status);
        }

        if ($kataKunci !== '') {
            $nomor = (int) preg_replace('/\D/', '', $kataKunci);   // "NSW-0012" menjadi 12
            $query->where(function ($w) use ($kataKunci, $nomor) {
                if ($nomor > 0) {
                    $w->where('id_pesanan', $nomor);
                }
                $w->orWhere('nama_penerima', 'like', '%' . $kataKunci . '%')
                  ->orWhereHas('user', fn ($u) => $u->where('nama', 'like', '%' . $kataKunci . '%'));
            });
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pesanan', '>=', $request->query('dari'));
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pesanan', '<=', $request->query('sampai'));
        }

        $pesanans = $query
            ->with(['user', 'pembayaran'])
            ->withCount('detailPesanans')
            ->orderByDesc('id_pesanan')
            ->paginate(10)
            ->withQueryString();

        $daftarStatus = [
            Pesanan::STATUS_BARU,
            Pesanan::STATUS_DIPROSES,
            Pesanan::STATUS_SIAP,
            Pesanan::STATUS_SELESAI,
            Pesanan::STATUS_BATAL,
        ];

        // Jumlah pesanan per status untuk chip filter dan kartu angka
        $jumlahPerStatus = Pesanan::selectRaw('status_pesanan, COUNT(*) as jumlah')
            ->groupBy('status_pesanan')
            ->pluck('jumlah', 'status_pesanan');

        $hariIni = Pesanan::whereDate('tanggal_pesanan', today());
        $ringkasan = [
            'hariIni'        => (clone $hariIni)->count(),
            'selesaiHariIni' => (clone $hariIni)->where('status_pesanan', Pesanan::STATUS_SELESAI)->count(),
            'baru'           => $jumlahPerStatus[Pesanan::STATUS_BARU] ?? 0,
            'diproses'       => $jumlahPerStatus[Pesanan::STATUS_DIPROSES] ?? 0,
            'siap'           => $jumlahPerStatus[Pesanan::STATUS_SIAP] ?? 0,
        ];

        return view('admin.pesanan.index', compact('pesanans', 'daftarStatus', 'status', 'jumlahPerStatus', 'ringkasan'));
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
