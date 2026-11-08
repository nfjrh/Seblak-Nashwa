@extends('layouts.pelanggan')

@section('title', 'Beranda')

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $menuPertama = $menus->first();
    $tiga = $menus->take(3);
    $daftarTopping = $toppings->map(fn ($t) => $t->nama_topping . ' ' . $rp($t->harga))->join(', ');
@endphp

{{-- Hero --}}
<section class="py-4 py-lg-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-6">
                <div class="nw-eyebrow mb-2">Seblak hangat, hari jadi nikmat</div>
                <h1 class="display-5 fw-bold mb-3">Lagi Mau yang Pedas?<br><span class="text-danger">Seblak Nashwa aja.</span></h1>
                <p class="text-muted fs-5 mb-4">Semangkuk hangat dengan topping pilihanmu. Racik seblak sesukamu, dari pedas santai sampai level 5.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-primary btn-lg px-4">Lihat Menu</a>
            </div>
            <div class="col-12 col-lg-6">
                <div class="position-relative">
                    <x-foto-menu :menu="$menuPertama" rasio="4x3" class="rounded-5" />
                    <span class="nw-badge position-absolute" style="top:1rem;left:1rem;background:#fff">Best Seller</span>
                    @if ($menuPertama)
                        <div class="position-absolute bg-white rounded-4 p-3 d-flex justify-content-between align-items-center shadow-sm" style="left:1rem;right:1rem;bottom:1rem">
                            <div>
                                <div class="fw-bold">{{ $menuPertama->nama_menu }}</div>
                                <div class="small text-muted">{{ $menuPertama->deskripsi }}</div>
                            </div>
                            <div class="nw-price fs-5">{{ $rp($menuPertama->harga) }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Keunggulan --}}
<section class="nw-strip py-3">
    <div class="container">
        <div class="row row-cols-2 row-cols-lg-4 g-3 small fw-semibold">
            <div class="col"><i class="bi bi-bag-check text-danger me-2"></i>Dimasak saat dipesan</div>
            <div class="col"><i class="bi bi-fire text-danger me-2"></i>Level pedas 0–5</div>
            <div class="col"><i class="bi bi-fork-knife text-danger me-2"></i>Topping sesuai selera</div>
            <div class="col"><i class="bi bi-bicycle text-danger me-2"></i>Ambil atau antar</div>
        </div>
    </div>
</section>

{{-- Pilihan seblak --}}
<section id="menu" class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
            <div>
                <div class="nw-eyebrow mb-1">Pilihan Seblak Nashwa</div>
                <h2 class="display-6 fw-bold mb-1">Mau seblak yang mana?</h2>
                <p class="text-muted mb-0">Pilih varianmu, lalu buat rasanya jadi lebih kamu.</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="fw-bold">Lihat semua menu di pemesanan <i class="bi bi-arrow-up-right"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-3">
            @forelse ($tiga as $m)
                <div class="col">
                    <a href="{{ route('katalog.show', $m->id_menu) }}" class="nw-card nw-menu p-3">
                        <x-foto-menu :menu="$m" rasio="4x3" class="rounded-4 mb-3" />
                        <h3 class="h4 mb-1">{{ $m->nama_menu }}</h3>
                        <p class="text-muted small mb-2">{{ $m->deskripsi }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="nw-price fs-4">{{ $rp($m->harga) }}</span>
                            <i class="bi bi-arrow-up-right text-danger fs-4"></i>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-muted">Menu belum tersedia. Jalankan seeder atau tambahkan menu dari halaman admin.</div>
            @endforelse
        </div>

        @if ($minuman)
            <a href="{{ route('katalog.show', $minuman->id_menu) }}" class="nw-card-soft d-flex align-items-center gap-3 p-3 mt-3 text-reset">
                <div style="width:72px;flex:none"><x-foto-menu :menu="$minuman" rasio="1x1" class="rounded-3" /></div>
                <div class="flex-grow-1">
                    <div class="h5 mb-0">Teman makan pedas: {{ $minuman->nama_menu }}</div>
                    <div class="small text-muted">{{ $minuman->deskripsi }}</div>
                </div>
                <div class="nw-price fs-4">{{ $rp($minuman->harga) }}</div>
            </a>
        @endif
    </div>
</section>

{{-- Cara pesan --}}
<section id="cara-pesan" class="pb-5">
    <div class="container">
        <div class="nw-eyebrow mb-1">Cara pesan</div>
        <h2 class="display-6 fw-bold mb-4">Dari pilih menu sampai siap dinikmati.</h2>
        <div class="row g-4">
            <div class="col-12 col-md-4 d-flex gap-3">
                <span class="nw-num">01</span>
                <div><h3 class="h5">Pilih seblakmu</h3><p class="text-muted">Buka halaman pemesanan dan pilih varian seblak yang kamu inginkan.</p></div>
            </div>
            <div class="col-12 col-md-4 d-flex gap-3">
                <span class="nw-num">02</span>
                <div><h3 class="h5">Racik sesuai selera</h3><p class="text-muted">Atur level pedas, pilih topping tambahan, dan tambahkan minuman.</p></div>
            </div>
            <div class="col-12 col-md-4 d-flex gap-3">
                <span class="nw-num">03</span>
                <div><h3 class="h5">Tentukan cara terima</h3><p class="text-muted">Pilih ambil di kedai atau pengantaran, lalu lanjutkan pembayaran.</p></div>
            </div>
        </div>
    </div>
</section>

{{-- Ambil atau antar --}}
<section class="pb-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-4">
                <div class="nw-eyebrow mb-1">Nikmati dengan caramu</div>
                <h2 class="h2 fw-bold">Mampir ke kedai atau tunggu di rumah.</h2>
                <p class="text-muted small">Pilih cara menerima pesanan yang paling nyaman untukmu saat memesan.</p>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="nw-card p-4 h-100">
                    <i class="bi bi-shop text-danger fs-4"></i>
                    <h3 class="h5 mt-2">Ambil di kedai</h3>
                    <p class="text-muted small">Pesan lewat web, lalu ambil pesananmu di kedai.</p>
                    <a href="{{ route('katalog.index') }}" class="small fw-bold">Pilih opsi ambil di kedai</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="nw-card p-4 h-100">
                    <i class="bi bi-bicycle text-danger fs-4"></i>
                    <h3 class="h5 mt-2">Pengantaran</h3>
                    <p class="text-muted small">Nikmati seblak tanpa harus keluar rumah.</p>
                    <a href="{{ route('katalog.index') }}" class="small fw-bold">Pilih opsi pengantaran</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Tentang --}}
<section id="tentang" class="py-5" style="background:#fffdf9">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-6"><x-foto-menu :menu="$menus->get(1) ?? $menuPertama" rasio="4x3" class="rounded-5" /></div>
            <div class="col-12 col-lg-6">
                <div class="nw-eyebrow mb-1">Kenalan dengan Nashwa</div>
                <h2 class="display-6 fw-bold mb-3">Kedai lokal untuk selera pedasmu.</h2>
                <p class="text-muted">Seblak Nashwa adalah kedai UMKM dengan pilihan seblak yang bisa kamu racik sesuai selera. Dari Original hingga Komplit, setiap mangkuk dimasak saat dipesan.</p>
                <p class="text-muted">Buat kami, menikmati seblak itu sederhana: pilih yang kamu suka, atur pedasnya, lalu nikmati selagi hangat.</p>
                <p class="fw-bold text-danger fs-5 mb-0">Pedasnya pas, nagihnya jelas.</p>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section id="faq" class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="nw-eyebrow mb-1">Sebelum kamu pesan</div>
                <h2 class="display-6 fw-bold">Masih penasaran?</h2>
                <p class="text-muted">Ini beberapa hal yang perlu kamu tahu sebelum menikmati Seblak Nashwa.</p>
            </div>
            <div class="col-12 col-lg-8">
                <div class="accordion accordion-flush" id="faqList">
                    @php
                        $faq = [
                            ['Bisa pilih level pedas sendiri?', 'Bisa. Pilih level 0–5 saat memilih seblak di halaman pemesanan.'],
                            ['Apa saja topping tambahannya?', $toppings->isNotEmpty() ? 'Pilihan topping: ' . $daftarTopping . '.' : 'Pilihan topping tersedia di halaman pemesanan.'],
                            ['Bisa ambil di kedai atau diantar?', 'Keduanya tersedia. Pilih cara menerima pesanan saat melanjutkan pemesanan.'],
                            ['Berapa biaya pengantarannya?', 'Biaya layanan dan pengantaran dihitung saat pembayaran. Cek rinciannya sebelum menyelesaikan pesanan.'],
                            ['Kapan saya bisa memesan?', 'Jam layanan kedai setiap hari, pukul 10.00–21.00 WITA.'],
                        ];
                    @endphp
                    @foreach ($faq as $i => [$tanya, $jawab])
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button {{ $i === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}">{{ $tanya }}</button>
                            </h3>
                            <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}" data-bs-parent="#faqList">
                                <div class="accordion-body text-muted pt-0">{{ $jawab }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer')
<footer class="nw-foot pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-5">
                <a href="{{ route('home') }}" class="nw-brand mb-3">
                    <span class="nw-brand-ico"><i class="bi bi-cup-hot-fill"></i></span>
                    <span><strong>Seblak Nashwa</strong><small>PEDASNYA PAS, NAGIHNYA JELAS.</small></span>
                </a>
                <p class="small text-muted mt-3">Dibuat hangat, disajikan sepenuh hati.<br>Seblak pilihanmu, dengan pedas yang pas untukmu.</p>
            </div>
            <div class="col-6 col-lg-2">
                <h4 class="h6">Jelajahi</h4>
                <ul class="list-unstyled small">
                    <li><a class="text-muted" href="{{ route('katalog.index') }}">Menu pilihan</a></li>
                    <li><a class="text-muted" href="#cara-pesan">Cara pesan</a></li>
                    <li><a class="text-muted" href="#tentang">Tentang kedai</a></li>
                    <li><a class="text-muted" href="#faq">FAQ</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h4 class="h6">Untuk kamu</h4>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('katalog.index') }}">Pesan sekarang</a></li>
                    <li><a href="{{ route('login') }}">Masuk / Daftar</a></li>
                    <li><a href="#" class="js-segera">Bantuan pemesanan</a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-3">
                <h4 class="h6">Jam layanan</h4>
                <div class="small text-muted">Setiap hari</div>
                <div class="fw-bold">10.00–21.00 WITA</div>
            </div>
        </div>
        <hr>
        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 small text-muted">
            <span>© {{ date('Y') }} Seblak Nashwa · Pedasnya pas, nagihnya jelas.</span>
            <span class="d-flex gap-4">
                <a href="#" class="text-muted js-segera">Kebijakan privasi</a>
                <a href="{{ route('admin.login') }}" class="text-muted">Masuk admin</a>
            </span>
        </div>
    </div>
</footer>

@endsection