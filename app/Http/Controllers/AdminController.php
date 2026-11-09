<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Topping;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Constructor: objek Pesanan disuntikkan otomatis oleh Laravel
    public function __construct(private Pesanan $pesanan)
    {
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! $user->isAdmin()) {
            Auth::logout();

            return redirect()->route('admin.login')
                ->withErrors([
                    'email' => 'Akses hanya diperbolehkan untuk admin.',
                ]);
        }

        // Semua angka dihitung dari pesanan yang tidak dibatalkan.
        $hariIni = Pesanan::whereDate('tanggal_pesanan', today())
            ->where('status_pesanan', '!=', Pesanan::STATUS_BATAL);

        $pesananHariIni = (clone $hariIni)->count();
        $selesaiHariIni = (clone $hariIni)->where('status_pesanan', Pesanan::STATUS_SELESAI)->count();
        $penjualanHariIni = (float) (clone $hariIni)->sum(DB::raw('total_harga - biaya_layanan - ongkir'));

        // Penjualan per jam (jam layanan 10.00 sampai 21.00)
        $penjualanPerJam = array_fill_keys(range(10, 21), 0.0);
        foreach ((clone $hariIni)->get(['tanggal_pesanan', 'total_harga', 'biaya_layanan', 'ongkir']) as $p) {
            $jam = (int) $p->tanggal_pesanan->format('G');
            if (isset($penjualanPerJam[$jam])) {
                $penjualanPerJam[$jam] += $p->subtotal_menu;
            }
        }

        return view('admin.dashboard', [
            'penjualanHariIni' => $penjualanHariIni,
            'pesananHariIni'   => $pesananHariIni,
            'totalPesanan'     => $pesananHariIni,
            'selesaiHariIni'   => $selesaiHariIni,
            'rataRata'         => $pesananHariIni > 0 ? $penjualanHariIni / $pesananHariIni : 0,
            'penjualanPerJam'  => $penjualanPerJam,

            // Jumlah pesanan per status: ['baru' => 2, 'diproses' => 3, ...]
            'jumlahStatus' => Pesanan::selectRaw('status_pesanan, COUNT(*) as jumlah')
                ->groupBy('status_pesanan')
                ->pluck('jumlah', 'status_pesanan'),

            'menuTersedia'  => Menu::where('status', Menu::STATUS_TERSEDIA)->count(),
            'totalMenu'     => Menu::count(),
            'totalKategori' => Kategori::count(),
            'menuUnggulan'  => Menu::with('kategori')->where('status', Menu::STATUS_TERSEDIA)->limit(2)->get(),
            'jumlahTopping' => Topping::count(),
            'daftarTopping' => Topping::orderBy('nama_topping')->pluck('nama_topping'),

            'pesananTerbaru' => Pesanan::with('user')
                ->orderByDesc('tanggal_pesanan')
                ->limit(5)
                ->get(),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (! $user->isAdmin()) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun ini bukan akun admin.',
                ])->onlyInput('email');
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}