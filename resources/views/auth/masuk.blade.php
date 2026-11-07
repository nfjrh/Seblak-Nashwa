@extends('layouts.pelanggan')

@section('title', 'Masuk')

@section('content')
@php
    $errMasuk  = $errors->getBag('masuk');
    $errDaftar = $errors->getBag('daftar');
    $tab = ($errDaftar->any() || request('tab') === 'daftar') ? 'daftar' : 'masuk';
@endphp
<div class="container py-4 py-md-5">

    <section class="nw-hero p-4 mb-4 mx-auto" style="max-width:860px">
        <div class="nw-eyebrow mb-1">Selamat datang di kedai kita</div>
        <h1 class="h2 fw-bold mb-2">Kenalan dulu, lalu pesan yang enak.</h1>
        <p class="text-muted small mb-2">Masuk untuk melanjutkan pesanan, atau buat akun agar alamat dan riwayat pesananmu tersimpan rapi.</p>
        <div class="d-flex flex-wrap gap-3 small fw-semibold">
            <span><i class="bi bi-geo-alt-fill text-danger"></i> Simpan alamatmu</span>
            <span><i class="bi bi-receipt text-danger"></i> Pantau setiap pesanan</span>
        </div>
    </section>

    <div class="nw-card p-3 p-md-4 mx-auto" style="max-width:520px">
        <ul class="nav nav-pills nav-fill mb-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $tab === 'masuk' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#tab-masuk" type="button" role="tab">Masuk</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $tab === 'daftar' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#tab-daftar" type="button" role="tab">Daftar</button>
            </li>
        </ul>

        <div class="tab-content">
            {{-- Masuk --}}
            <div class="tab-pane fade {{ $tab === 'masuk' ? 'show active' : '' }}" id="tab-masuk" role="tabpanel">
                <h2 class="h4 mb-1">Senang kamu kembali!</h2>
                <p class="text-muted small mb-3">Masuk dengan akun pelanggan Seblak Nashwa.</p>

                @if ($errMasuk->any())
                    <div class="alert alert-danger py-2 small">{{ $errMasuk->first() }}</div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="identitas" class="form-label">Nomor WhatsApp atau email</label>
                        <input type="text" id="identitas" name="identitas" value="{{ old('identitas') }}"
                               class="form-control" placeholder="Contoh: 081234567890" autocomplete="username">
                    </div>
                    <div class="mb-3">
                        <label for="login-password" class="form-label">Kata sandi</label>
                        <div class="input-group">
                            <input type="password" id="login-password" name="password" class="form-control" placeholder="Masukkan kata sandi" autocomplete="current-password">
                            <button class="btn btn-outline-dark js-lihat" type="button" data-target="login-password" aria-label="Tampilkan kata sandi"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ingat" value="1" id="ingat">
                            <label class="form-check-label small" for="ingat">Ingat saya</label>
                        </div>
                        <a href="#" class="small fw-bold js-segera">Lupa kata sandi?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Masuk &amp; lanjut pesan <i class="bi bi-arrow-right"></i></button>
                </form>
                <p class="small text-center text-muted mt-3 mb-0">Belum punya akun? Buka tab <strong>Daftar</strong> untuk mulai memesan.</p>
            </div>

            {{-- Daftar --}}
            <div class="tab-pane fade {{ $tab === 'daftar' ? 'show active' : '' }}" id="tab-daftar" role="tabpanel">
                <h2 class="h4 mb-1">Yuk, buat akun pelanggan.</h2>
                <p class="text-muted small mb-3">Daftar sebentar, pesan favoritmu jadi lebih mudah.</p>

                @if ($errDaftar->any())
                    <div class="alert alert-danger small py-2">
                        <ul class="mb-0 ps-3">@foreach ($errDaftar->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('register.submit') }}" method="POST" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-control" placeholder="Masukkan nama lengkap" autocomplete="name">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="nomor_hp" class="form-label">Nomor WhatsApp</label>
                            <input type="tel" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" class="form-control" placeholder="Contoh: 081234567890" autocomplete="tel">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="email" class="form-label">Email <span class="text-muted fw-normal">(opsional)</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="nama@email.com" autocomplete="email">
                        </div>
                    </div>
                    <div class="mb-1">
                        <label for="reg-password" class="form-label">Kata sandi</label>
                        <div class="input-group">
                            <input type="password" id="reg-password" name="password" class="form-control" placeholder="Buat kata sandi" autocomplete="new-password">
                            <button class="btn btn-outline-dark js-lihat" type="button" data-target="reg-password" aria-label="Tampilkan kata sandi"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="form-text mb-3">Minimal 8 karakter, gunakan kombinasi huruf dan angka.</div>
                    <div class="mb-3">
                        <label for="reg-password2" class="form-label">Konfirmasi kata sandi</label>
                        <div class="input-group">
                            <input type="password" id="reg-password2" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" autocomplete="new-password">
                            <button class="btn btn-outline-dark js-lihat" type="button" data-target="reg-password2" aria-label="Tampilkan kata sandi"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="setuju" value="1" id="setuju" {{ old('setuju') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="setuju">Saya menyetujui ketentuan penggunaan dan kebijakan privasi Seblak Nashwa.</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Daftar &amp; mulai pesan <i class="bi bi-arrow-right"></i></button>
                </form>
                <p class="small text-center text-muted mt-3 mb-0"><i class="bi bi-shield-check"></i> Data kamu hanya digunakan untuk kebutuhan pemesanan.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tombol mata: tampilkan atau sembunyikan kata sandi
    document.querySelectorAll('.js-lihat').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            const kolom = document.getElementById(this.dataset.target);
            const lihat = kolom.type === 'password';
            kolom.type = lihat ? 'text' : 'password';
            this.innerHTML = lihat ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });
    });
</script>
@endpush