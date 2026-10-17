<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Pesanan;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        if (Auth::user()->role !== 'admin') {
            Auth::logout();

            return redirect()->route('admin.login')
                ->withErrors([
                    'email' => 'Akses hanya diperbolehkan untuk admin.',
                ]);
        }

        return view('admin.dashboard', [
            'totalPesanan' => Pesanan::count(),

            'totalNilaiPesanan' => Pesanan::sum('total_harga'),

            'pesananDiproses' => Pesanan::whereIn('status_pesanan', [
                'diproses',
                'disiapkan',
                'siap dikirim',
            ])->count(),

            'totalMenu' => Menu::count(),

            'totalKategori' => Kategori::count(),

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

            if (Auth::user()->role !== 'admin') {
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
