<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthPelangganController extends Controller
{
    public function form()
    {
        return view('auth.masuk');
    }

    public function login(Request $request)
    {
        $data = $request->validateWithBag('masuk', [
            'identitas' => ['required', 'string', 'max:150'],
            'password'  => ['required', 'string'],
        ], [
            'identitas.required' => 'Isi nomor WhatsApp atau email kamu.',
            'password.required'  => 'Isi kata sandi kamu.',
        ]);

        $identitas = trim($data['identitas']);

        $user = str_contains($identitas, '@')
            ? User::where('email', Str::lower($identitas))->first()
            : User::where('nomor_hp', $this->normalisasiHp($identitas))->first();

        if (! $user || ! $this->passwordCocok($data['password'], $user->password)) {
            return back()
                ->withErrors(['identitas' => 'Nomor/email atau kata sandi salah.'], 'masuk')
                ->onlyInput('identitas');
        }

        if ($user->role !== 'pembeli') {
            return back()
                ->withErrors(['identitas' => 'Akun admin masuk lewat halaman admin.'], 'masuk')
                ->onlyInput('identitas');
        }

        Auth::login($user, $request->boolean('ingat'));
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function daftar(Request $request)
    {
        // rapikan input sebelum divalidasi
        $request->merge([
            'nomor_hp' => $this->normalisasiHp((string) $request->input('nomor_hp')),
            'email'    => $request->filled('email') ? Str::lower(trim($request->input('email'))) : null,
        ]);

        $data = $request->validateWithBag('daftar', [
            'nama'     => ['required', 'string', 'max:100'],
            'nomor_hp' => ['required', 'regex:/^08[0-9]{8,12}$/', 'unique:users,nomor_hp'],
            'email'    => ['nullable', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'setuju'   => ['accepted'],
        ], [
            'nama.required'     => 'Isi nama lengkap kamu.',
            'nomor_hp.required' => 'Isi nomor WhatsApp kamu.',
            'nomor_hp.regex'    => 'Nomor WhatsApp tidak valid. Contoh: 081234567890.',
            'nomor_hp.unique'   => 'Nomor ini sudah terdaftar. Silakan masuk.',
            'email.email'       => 'Format email belum benar.',
            'email.unique'      => 'Email ini sudah terdaftar. Silakan masuk.',
            'password.required' => 'Buat kata sandi dulu.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
            'password.min'      => 'Kata sandi minimal 8 karakter.',
            'setuju.accepted'   => 'Centang persetujuan dulu ya.',
        ]);

        $user = User::create([
            'nama'     => $data['nama'],
            'nomor_hp' => $data['nomor_hp'],
            'email'    => $data['email'] ?? null,
            'password' => $data['password'], // otomatis di-hash oleh model User
            'role'     => 'pembeli',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('status', 'Akun berhasil dibuat. Selamat datang, ' . Str::of($user->nama)->before(' ') . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /** 0812..., +62812..., 62812..., 812... -> 0812... */
    private function normalisasiHp(string $nomor): string
    {
        $digit = preg_replace('/\D+/', '', $nomor) ?? '';

        if (str_starts_with($digit, '62')) {
            return '0' . substr($digit, 2);
        }

        if (str_starts_with($digit, '8')) {
            return '0' . $digit;
        }

        return $digit;
    }

    /** Hash::check melempar error kalau isi kolom bukan hash bcrypt; anggap saja salah. */
    private function passwordCocok(string $input, string $hash): bool
    {
        try {
            return Hash::check($input, $hash);
        } catch (\RuntimeException) {
            return false;
        }
    }
}
