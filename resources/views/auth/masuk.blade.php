@extends('layouts.app')

@section('title', 'Masuk atau Daftar')

{{-- navbar khusus halaman ini --}}
@section('nav_links')
    <a href="{{ url('/') }}#menu" class="active">Menu</a>
    <a href="{{ Route::has('pesanan.riwayat') ? route('pesanan.riwayat') : route('login') }}">Pesanan saya</a>
    <a href="{{ url('/') }}#tentang">Tentang kedai</a>
@endsection

@section('nav_action')
    <a href="{{ route('home') }}" class="btn btn-outline"><x-icon name="arrow-left" /> Kembali ke menu</a>
@endsection

@section('content')
@php
    $errMasuk  = $errors->getBag('masuk');
    $errDaftar = $errors->getBag('daftar');
    $img = fn ($file) => file_exists(public_path('images/' . $file)) ? asset('images/' . $file) : null;
@endphp

<div class="wrap auth">
    {{-- Banner sambutan --}}
    <section class="auth-hero">
        <div class="auth-hero-txt">
            <span class="eyebrow">SELAMAT DATANG DI KEDAI KITA</span>
            <h1>Kenalan dulu, lalu pesan yang enak.</h1>
            <p>Masuk untuk melanjutkan pesanan, atau buat akun agar alamat dan riwayat pesananmu tersimpan rapi.</p>
            <div class="chips">
                <span><x-icon name="map-pin" /> Simpan alamatmu</span>
                <span><x-icon name="receipt" /> Pantau setiap pesanan</span>
            </div>
        </div>
        <div class="media media-auth">
            <x-foto :src="$img('hero.jpg')" alt="Semangkuk seblak" />
        </div>
    </section>

    <div class="auth-grid">
        {{-- ========== MASUK ========== --}}
        <section class="card">
            <span class="pill">Sudah punya akun</span>
            <h2>Senang kamu kembali!</h2>
            <p class="sub">Masuk dengan akun pelanggan Seblak Nashwa.</p>

            <form action="{{ route('login.submit') }}" method="POST" novalidate>
                @csrf

                <div class="field">
                    <label for="identitas">Nomor WhatsApp atau email</label>
                    <div class="input">
                        <input type="text" id="identitas" name="identitas" value="{{ old('identitas') }}"
                               placeholder="Contoh: 081234567890" autocomplete="username" required>
                        <x-icon name="user" />
                    </div>
                    @if ($errMasuk->has('identitas')) <p class="err">{{ $errMasuk->first('identitas') }}</p> @endif
                </div>

                <div class="field">
                    <label for="login-password">Kata sandi</label>
                    <div class="input">
                        <input type="password" id="login-password" name="password"
                               placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                        <button type="button" class="eye" data-target="login-password" aria-label="Tampilkan kata sandi">
                            <x-icon name="eye-off" />
                        </button>
                    </div>
                    @if ($errMasuk->has('password')) <p class="err">{{ $errMasuk->first('password') }}</p> @endif
                </div>

                <div class="row-between">
                    <label class="check"><input type="checkbox" name="ingat" value="1"> Ingat saya</label>
                    <a href="#" class="red-link">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-block"><x-icon name="arrow-right" /> Masuk &amp; lanjut pesan</button>
            </form>

            <hr class="sep">
            <p class="small center">Belum punya akun? Isi formulir daftar di sebelah untuk mulai memesan.</p>
        </section>

        {{-- ========== DAFTAR ========== --}}
        <section class="card" id="daftar">
            <span class="pill">Baru di sini?</span>
            <h2>Yuk, buat akun pelanggan.</h2>
            <p class="sub">Daftar sebentar, pesan favoritmu jadi lebih mudah.</p>

            <form action="{{ route('register.submit') }}" method="POST" novalidate>
                @csrf

                <div class="field">
                    <label for="nama">Nama lengkap</label>
                    <div class="input">
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                               placeholder="Masukkan nama lengkap" autocomplete="name" required>
                    </div>
                    @if ($errDaftar->has('nama')) <p class="err">{{ $errDaftar->first('nama') }}</p> @endif
                </div>

                <div class="two">
                    <div class="field">
                        <label for="nomor_hp">Nomor WhatsApp</label>
                        <div class="input">
                            <input type="tel" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}"
                                   placeholder="Contoh: 081234567890" autocomplete="tel" required>
                        </div>
                        @if ($errDaftar->has('nomor_hp')) <p class="err">{{ $errDaftar->first('nomor_hp') }}</p> @endif
                    </div>

                    <div class="field">
                        <label for="email">Email (opsional)</label>
                        <div class="input">
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   placeholder="nama@email.com" autocomplete="email">
                        </div>
                        @if ($errDaftar->has('email')) <p class="err">{{ $errDaftar->first('email') }}</p> @endif
                    </div>
                </div>

                <div class="field">
                    <label for="reg-password">Kata sandi</label>
                    <div class="input">
                        <input type="password" id="reg-password" name="password"
                               placeholder="Buat kata sandi" autocomplete="new-password" required>
                        <button type="button" class="eye" data-target="reg-password" aria-label="Tampilkan kata sandi">
                            <x-icon name="eye-off" />
                        </button>
                    </div>
                    <p class="hint">Minimal 8 karakter, gunakan kombinasi huruf dan angka.</p>
                    @if ($errDaftar->has('password')) <p class="err">{{ $errDaftar->first('password') }}</p> @endif
                </div>

                <div class="field">
                    <label for="reg-password2">Konfirmasi kata sandi</label>
                    <div class="input">
                        <input type="password" id="reg-password2" name="password_confirmation"
                               placeholder="Ulangi kata sandi" autocomplete="new-password" required>
                        <button type="button" class="eye" data-target="reg-password2" aria-label="Tampilkan kata sandi">
                            <x-icon name="eye-off" />
                        </button>
                    </div>
                </div>

                <label class="check check-small">
                    <input type="checkbox" name="setuju" value="1" {{ old('setuju') ? 'checked' : '' }}>
                    Saya menyetujui ketentuan penggunaan dan kebijakan privasi Seblak Nashwa.
                </label>
                @if ($errDaftar->has('setuju')) <p class="err">{{ $errDaftar->first('setuju') }}</p> @endif

                <button type="submit" class="btn btn-primary btn-block"><x-icon name="arrow-right" /> Daftar &amp; mulai pesan</button>
            </form>

            <p class="small center secure"><x-icon name="shield" /> Data kamu hanya digunakan untuk kebutuhan pemesanan.</p>
        </section>
    </div>
</div>
@endsection

{{-- footer sederhana khusus halaman ini --}}
@section('footer')
    <footer class="foot foot-simple">
        <div class="wrap foot-bottom">
            <span>© {{ date('Y') }} Seblak Nashwa · Dibuat hangat, disajikan sepenuh hati.</span>
            <span class="foot-links">
                <a href="{{ url('/') }}#faq">Bantuan pemesanan</a>
                <a href="#">Kebijakan privasi</a>
                <a href="{{ route('admin.login') }}" class="red-link">Masuk admin <x-icon name="arrow-up-right" /></a>
            </span>
        </div>
    </footer>
@endsection

@push('scripts')
<script>
    // tombol mata: tampilkan / sembunyikan kata sandi
    document.querySelectorAll('.eye').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.target);
            var tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            btn.setAttribute('aria-label', tampil ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });
    });

    // kalau pendaftaran gagal, langsung gulir ke formulir daftar
    @if ($errors->getBag('daftar')->any())
        document.getElementById('daftar').scrollIntoView({ block: 'start' });
    @endif
</script>
@endpush
