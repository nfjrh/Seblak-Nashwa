@extends('layouts.app')

@section('title', 'Seblak Nashwa')

@section('content')
@php
    // Foto: taruh file di public/images/ dengan nama hero.jpg, tentang.jpg
    $img = fn ($file) => file_exists(public_path('images/' . $file)) ? asset('images/' . $file) : null;
    $rp  = fn ($angka) => 'Rp' . number_format((float) $angka, 0, ',', '.');

    $tautMenu    = Route::has('menu.index') ? route('menu.index') : '#menu';
    $menuPertama = $menus->first();

    $deskripsiLevel = ['Tanpa pedas', 'Pedas ringan', 'Pedas sedang', 'Pedas mantap', 'Sangat pedas', 'Level nekat'];
@endphp

{{-- ========== HERO ========== --}}
<section class="hero">
    <div class="wrap hero-grid">
        <div class="hero-txt">
            <span class="eyebrow">SEBLAK RUMAHAN · MAKASSAR</span>
            <h1>Lagi pengin pedas?<br><em>Nashwa-in aja.</em></h1>
            <p class="lead">Semangkuk hangat dengan topping pilihanmu. Racik sesuai seleramu, dari tanpa pedas sampai level 5.</p>

            <div class="btn-row">
                <a href="{{ $tautMenu }}" class="btn btn-primary">Pesan Sekarang <x-icon name="arrow-right" /></a>
                <a href="#menu" class="btn btn-ghost">Lihat Menu</a>
            </div>

            @if ($hargaMulai)
                <p class="hero-note"><x-icon name="receipt" /> Mulai dari {{ $rp($hargaMulai) }}</p>
            @endif
        </div>

        <div class="hero-card">
            <div class="media media-hero">
                <x-foto :src="$menuPertama?->fotoUrl() ?? $img('hero.jpg')" alt="Semangkuk seblak" />
            </div>

            @if ($menuPertama)
                <div class="hero-tag">
                    <div>
                        <strong>{{ $menuPertama->nama_menu }}</strong>
                        <small>{{ \Illuminate\Support\Str::limit($menuPertama->deskripsi, 48) }}</small>
                    </div>
                    <span class="price-pill">{{ $rp($menuPertama->harga) }}</span>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ========== JALUR KEUNGGULAN ========== --}}
<section class="strip">
    <div class="wrap strip-in">
        <div><x-icon name="flame" /> Dimasak saat dipesan</div>
        <div><x-icon name="flame" /> Level pedas 0–5</div>
        <div><x-icon name="layers" /> Topping sesukamu</div>
        <div><x-icon name="bike" /> Ambil atau antar</div>
    </div>
</section>

{{-- ========== MENU ========== --}}
<section class="sec" id="menu">
    <div class="wrap">
        <div class="sec-head">
            <div>
                <span class="eyebrow">PILIHAN MALAM INI?</span>
                <h2>Mau seblak yang mana?</h2>
                <p class="sub">Pilih varianmu, lalu buat rasa sesuai lidahmu.</p>
            </div>
            <a href="{{ $tautMenu }}" class="more">Lihat semua menu &amp; pemesanan <x-icon name="arrow-right" /></a>
        </div>

        @if ($menus->isEmpty())
            <div class="kosong">Menu belum tersedia. Jalankan <code>php artisan db:seed --class=KedaiSeeder</code>.</div>
        @else
            <div class="menu-grid">
                @foreach ($menus as $menu)
                    <a class="menu-card" href="{{ Route::has('menu.show') ? route('menu.show', $menu->id_menu) : $tautMenu }}">
                        <div class="media media-card">
                            <x-foto :src="$menu->fotoUrl()" :alt="$menu->nama_menu" />
                        </div>
                        <div class="menu-body">
                            <h3>{{ $menu->nama_menu }}</h3>
                            <p>{{ $menu->deskripsi }}</p>
                            <div class="menu-foot">
                                <strong>{{ $rp($menu->harga) }}</strong>
                                <span class="go"><x-icon name="arrow-up-right" /></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        @if ($minuman)
            <div class="drink">
                <div class="drink-ico"><x-icon name="cup" /></div>
                <div class="drink-txt">
                    <strong>Teman makan pedas: {{ $minuman->nama_menu }}</strong>
                    <small>{{ $minuman->deskripsi }}</small>
                </div>
                <span class="drink-price">{{ $rp($minuman->harga) }}</span>
            </div>
        @endif
    </div>
</section>

{{-- ========== LEVEL PEDAS & TOPPING ========== --}}
<section class="sec sec-peach" id="racik">
    <div class="wrap">
        <span class="eyebrow">SATU MANGKUK, DIRACIK SENDIRI</span>
        <h2>Pedasnya kamu atur. Toppingnya kamu pilih.</h2>
        <p class="sub">Sesuaikan level pedas dan tambahkan topping, total harga dihitung otomatis saat memesan.</p>

        <div class="racik-grid">
            <div class="panel">
                <div class="panel-title"><x-icon name="flame" /> Dari level 0 sampai 5</div>

                <div class="lv-row" id="lv-row">
                    @foreach ($levels as $i => $level)
                        <button type="button"
                                class="lv {{ $i === 3 ? 'on' : '' }}"
                                data-i="{{ $i }}"
                                aria-pressed="{{ $i === 3 ? 'true' : 'false' }}">{{ $i }}</button>
                    @endforeach
                </div>

                <div class="lv-info">
                    <span id="lv-nama">Level 3</span>
                    <span id="lv-desk" class="muted">{{ $deskripsiLevel[3] }}</span>
                </div>
                <p class="note">Tidak kuat pedas? Pilih level 0. Mau lebih menantang? Naikkan pelan-pelan sampai level 5.</p>
            </div>

            <div class="panel">
                <div class="panel-title"><x-icon name="layers" /> Biar makin rame</div>

                @forelse ($toppings as $topping)
                    <div class="top-row">
                        <span>{{ $topping->nama_topping }}</span>
                        <span class="plus">+{{ $rp($topping->harga) }}</span>
                    </div>
                @empty
                    <p class="muted">Topping belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ========== CARA PESAN ========== --}}
<section class="sec" id="cara-pesan">
    <div class="wrap">
        <span class="eyebrow">CARA PESAN</span>
        <h2>Dari pilih menu sampai siap dinikmati.</h2>

        <div class="steps">
            <div class="step">
                <span class="step-no">01</span>
                <h3>Pilih seblakmu</h3>
                <p>Buka menu, pilih varian seblak yang kamu mau, lalu masukkan ke keranjang.</p>
            </div>
            <div class="step">
                <span class="step-no">02</span>
                <h3>Racik sesuai selera</h3>
                <p>Atur level pedas, pilih topping tambahan, dan tulis catatan kalau ada permintaan khusus.</p>
            </div>
            <div class="step">
                <span class="step-no">03</span>
                <h3>Tentukan cara terima</h3>
                <p>Pilih ambil di kedai atau diantar, lalu selesaikan pembayaran dan pantau statusnya.</p>
            </div>
        </div>
    </div>
</section>

{{-- ========== AMBIL / ANTAR ========== --}}
<section class="sec sec-peach">
    <div class="wrap pickup">
        <div>
            <span class="eyebrow">PILIH CARA TERIMA</span>
            <h2>Mampir ke kedai atau tunggu di rumah.</h2>
            <p class="sub">Pilih yang paling nyaman buatmu, pesanan tetap dimasak saat kamu pesan.</p>
        </div>

        <div class="pick-card">
            <span class="pick-ico"><x-icon name="bag" /></span>
            <h3>Ambil di kedai</h3>
            <p>Pesan lewat web, lalu datang saat statusnya sudah siap diambil.</p>
            <small>Hemat dan tanpa menunggu lama.</small>
        </div>

        <div class="pick-card">
            <span class="pick-ico"><x-icon name="bike" /></span>
            <h3>Pengantaran</h3>
            <p>Isi alamatmu saat memesan, pesanan diantar ke rumah.</p>
            <small>Biaya antar diinformasikan sebelum pesanan diproses.</small>
        </div>
    </div>
</section>

{{-- ========== TENTANG ========== --}}
<section class="sec" id="tentang">
    <div class="wrap about">
        <div class="media media-about">
            <x-foto :src="$img('tentang.jpg')" alt="Suasana kedai Seblak Nashwa" />
            <span class="about-tag">Dibuat hangat, disajikan sepenuh hati</span>
        </div>

        <div>
            <span class="eyebrow">KENALAN DENGAN NASHWA</span>
            <h2>Kedai lokal untuk<br>selera pedasmu.</h2>
            <p>Seblak Nashwa adalah usaha rumahan di Makassar yang berdiri sejak 2024. Seblak Sayap dan Seblak Ceker menjadi yang paling sering dipesan, dan variasi menu terus bertambah.</p>
            <p>Kuah dikemas terpisah supaya topping tidak lembek saat dibawa pulang. Dan setiap mangkuk dimasak saat kamu memesan.</p>
            <p class="strong-red">Pedasnya pas, nagihnya jelas.</p>
        </div>
    </div>
</section>

{{-- ========== INFO ========== --}}
<section class="strip strip-info">
    <div class="wrap info-in">
        <div>
            <x-icon name="clock" />
            <span><strong>Jam layanan</strong><small>Setiap hari, 10.00–21.00 WIB</small></span>
        </div>
        <div>
            <x-icon name="flame" />
            <span><strong>Dimasak saat dipesan</strong><small>Hangat dan segar saat sampai</small></span>
        </div>
        <div>
            <x-icon name="receipt" />
            <span><strong>Rincian biaya</strong><small>Total harga terlihat jelas sebelum bayar</small></span>
        </div>
    </div>
</section>

{{-- ========== FAQ ========== --}}
<section class="sec" id="faq">
    <div class="wrap faq-grid">
        <div>
            <span class="eyebrow">SEBELUM KAMU PESAN</span>
            <h2>Masih penasaran?</h2>
            <p class="sub">Beberapa pertanyaan yang sering muncul tentang Seblak Nashwa.</p>
        </div>

        <div class="faq">
            <details>
                <summary>Bisa pilih level pedas sendiri?</summary>
                <p>Bisa. Level 0 untuk yang tidak tahan pedas sama sekali, sampai level 5 untuk yang suka tantangan.</p>
            </details>
            <details>
                <summary>Apa saja topping tambahannya?</summary>
                <p>Ada sayap, ceker, seafood, dan beberapa pilihan lain. Jumlah topping tidak dibatasi, dan harganya ditampilkan jelas di atas.</p>
            </details>
            <details>
                <summary>Apakah kuah dikemas terpisah?</summary>
                <p>Ya, kuah dikemas terpisah supaya topping tidak lembek saat dibawa pulang.</p>
            </details>
            <details>
                <summary>Bisa ambil di kedai atau diantar?</summary>
                <p>Keduanya bisa. Pilih cara terima saat checkout, lalu pantau statusnya dari halaman pesanan.</p>
            </details>
            <details>
                <summary>Kapan saya bisa memesan?</summary>
                <p>Setiap hari pukul 10.00–21.00 WIB.</p>
            </details>
        </div>
    </div>
</section>

{{-- ========== AJAKAN AKHIR ========== --}}
<section class="wrap cta-wrap">
    <div class="cta">
        <div class="cta-txt">
            <span class="eyebrow eyebrow-light">SIAP DIMASAK SEKARANG?</span>
            <h2>Yuk, Nashwa-in harimu.</h2>
            <p>Pilih seblak, racik sesuai selera, dan pesan sekarang.</p>
            <a href="{{ $tautMenu }}" class="btn btn-light">Pesan Sekarang <x-icon name="arrow-right" /></a>
        </div>
        <div class="media media-cta">
            <x-foto :src="$menuPertama?->fotoUrl() ?? $img('hero.jpg')" alt="Seblak Nashwa" />
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function () {
        var desk = @json($deskripsiLevel);
        var tombol = document.querySelectorAll('#lv-row .lv');
        var nama = document.getElementById('lv-nama');
        var teks = document.getElementById('lv-desk');

        tombol.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var i = parseInt(btn.dataset.i, 10);
                tombol.forEach(function (b) {
                    var aktif = b === btn;
                    b.classList.toggle('on', aktif);
                    b.setAttribute('aria-pressed', aktif ? 'true' : 'false');
                });
                nama.textContent = 'Level ' + i;
                teks.textContent = desk[i] || '';
            });
        });
    })();
</script>
@endpush
