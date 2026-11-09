<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Admin | Seblak Nashwa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/tema.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<header class="nw-nav">
    <div class="container d-flex align-items-center justify-content-between py-2">
        <a href="{{ route('home') }}" class="nw-brand">
            <span class="nw-brand-ico"><i class="bi bi-cup-hot-fill"></i></span>
            <span><strong>Seblak Nashwa</strong><small>PEDASNYA PAS, NAGIHNYA JELAS.</small></span>
        </a>
        <span class="small fw-bold text-danger"><i class="bi bi-shield-check me-1"></i> Portal admin</span>
    </div>
</header>

<main class="flex-grow-1 d-flex align-items-center py-4 py-md-5">
    <div class="container" style="max-width:980px">
        <div class="nw-card overflow-hidden">
            <div class="row g-0">
                <div class="col-12 col-lg-5 pn-login-kiri p-4 p-md-5 d-flex flex-column justify-content-center">
                    <div class="small fw-bold mb-3" style="color:#F6C9A0"><i class="bi bi-shield-check me-1"></i> KHUSUS PENGELOLA KEDAI</div>
                    <h1 class="display-6 fw-bold mb-3">Dapur tertata.<br>Pesanan lancar.<br>Pelanggan senang.</h1>
                    <p class="text-muted small mb-3">Satu tempat untuk mengelola pesanan, memperbarui menu, dan melihat penjualan Seblak Nashwa.</p>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1"><i class="bi bi-check2 me-2"></i>Pantau pesanan yang masuk</li>
                        <li class="mb-1"><i class="bi bi-check2 me-2"></i>Atur menu dan stok topping</li>
                        <li><i class="bi bi-check2 me-2"></i>Lihat ringkasan penjualan harian</li>
                    </ul>
                </div>

                <div class="col-12 col-lg-7 p-4 p-md-5">
                    <span class="nw-badge mb-3"><i class="bi bi-lock"></i> Area admin</span>
                    <h2 class="h3 fw-bold">Masuk admin</h2>
                    <p class="text-muted small mb-4">Gunakan akun pengelola untuk mengakses operasional kedai.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email admin</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-control" placeholder="admin@seblaknashwa.id" autocomplete="username" autofocus>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label">Kata sandi</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="Masukkan kata sandi admin" autocomplete="current-password">
                                <button class="btn btn-outline-dark js-lihat" type="button" data-target="password" aria-label="Tampilkan kata sandi"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                        <div class="text-end mb-3"><a href="#" class="small fw-bold js-segera">Lupa kata sandi?</a></div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Masuk ke dasbor</button>
                    </form>

                    <div class="nw-card-soft p-3 small text-muted mt-3">
                        <i class="bi bi-info-circle me-1"></i> Akses terbatas untuk admin. Jangan bagikan akun dan selalu keluar setelah menggunakan perangkat bersama.
                    </div>
                    <hr>
                    <p class="small text-center text-muted mb-0">Ingin pesan seblak? <a href="{{ route('login') }}" class="fw-bold">Masuk sebagai pelanggan</a></p>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="nw-foot py-3">
    <div class="container small text-muted d-flex flex-column flex-md-row justify-content-between gap-2">
        <span>© {{ date('Y') }} Seblak Nashwa · Dibuat hangat, disajikan sepenuh hati.</span>
        <a href="{{ route('home') }}" class="text-muted">Kembali ke website</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('partials.swal')
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
</body>
</html>
