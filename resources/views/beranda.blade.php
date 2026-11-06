@extends('layouts.app')

@section('title', 'Seblak Nashwa')

@push('styles')
<style>
    /* ===== Landing page publik: Seblak Nashwa ===== */
    .lp-eyebrow { display: inline-block; font-size: 11px; font-weight: 800; letter-spacing: .1em; color: var(--brand); text-transform: uppercase; margin-bottom: 12px; }
    .lp h2 { font-size: 34px; line-height: 1.15; font-weight: 800; letter-spacing: -.01em; }
    .lp .lp-sub { margin-top: 10px; color: var(--muted); font-size: 15px; max-width: 560px; }
    .lp-sec { padding: 72px 0; }
    .lp-peach { background: #fdeedd; }

    /* hero */
    .lp-hero { padding: 54px 0 56px; background: var(--bg); }
    .lp-hero-grid { display: grid; grid-template-columns: 1fr 1.08fr; gap: 56px; align-items: center; }
    .lp-hero h1 { font-size: 52px; line-height: 1.08; font-weight: 800; letter-spacing: -.02em; }
    .lp-hero h1 em { display: block; font-style: normal; color: var(--brand); }
    .lp-hero .lp-lead { margin-top: 18px; color: var(--muted); font-size: 16px; max-width: 460px; }
    .lp-hero .btn-row { margin-top: 26px; }
    .lp-note { margin-top: 20px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--muted); }
    .lp-note .ico { color: var(--brand); width: 16px; height: 16px; }
    .lp-note strong { color: var(--ink); }
    .lp-hero-card { position: relative; border-radius: 24px; overflow: hidden; box-shadow: var(--shadow); aspect-ratio: 4 / 3.15; background: var(--soft); }
    .lp-hero-card img, .lp-hero-card .ph { width: 100%; height: 100%; object-fit: cover; }
    .lp-hero-tag { position: absolute; left: 16px; right: 16px; bottom: 16px; background: #fff; border-radius: 14px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-shadow: 0 8px 22px rgba(60, 30, 10, .16); }
    .lp-hero-tag strong { display: block; font-size: 15px; }
    .lp-hero-tag small { color: var(--muted); font-size: 12px; }
    .lp-hero-tag .lp-price { font-size: 20px; font-weight: 800; color: var(--brand); white-space: nowrap; }

    /* jalur keunggulan */
    .lp-strip { background: #fdf0e0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
    .lp-strip-in { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; padding-top: 16px; padding-bottom: 16px; }
    .lp-strip-in div { display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 13px; font-weight: 600; color: #5a3b2e; }
    .lp-strip-in .ico { color: var(--brand); width: 18px; height: 18px; }

    /* menu */
    .lp-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; flex-wrap: wrap; margin-bottom: 28px; }
    .lp-more { font-size: 13px; font-weight: 700; color: var(--brand); display: inline-flex; align-items: center; gap: 6px; }
    .lp-more .ico { width: 14px; height: 14px; }
    .lp-menu-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .lp-card { background: #fff; border: 1px solid var(--line); border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: .2s; }
    .lp-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
    .lp-card-img { position: relative; aspect-ratio: 4 / 3; background: var(--soft); }
    .lp-card-img img, .lp-card-img .ph { width: 100%; height: 100%; object-fit: cover; }
    .lp-badge { position: absolute; left: 12px; top: 12px; background: var(--brand); color: #fff; font-size: 11px; font-weight: 700; padding: 5px 11px; border-radius: 999px; }
    .lp-card-body { padding: 16px 18px 18px; display: flex; flex-direction: column; flex: 1; }
    .lp-card-body h3 { font-size: 16px; font-weight: 800; }
    .lp-card-body p { margin-top: 4px; font-size: 12.5px; color: var(--muted); flex: 1; }
    .lp-card-foot { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
    .lp-card-foot strong { color: var(--brand); font-size: 17px; font-weight: 800; }
    .lp-card-foot .ico { color: var(--brand); width: 16px; height: 16px; }
    .lp-drink { margin-top: 24px; background: #fdeedd; border-radius: 16px; padding: 14px 22px 14px 14px; display: flex; align-items: center; gap: 16px; }
    .lp-drink-img { width: 64px; height: 52px; border-radius: 10px; overflow: hidden; flex: none; background: var(--soft); }
    .lp-drink-img img, .lp-drink-img .ph { width: 100%; height: 100%; object-fit: cover; }
    .lp-drink-img .ph span { font-size: 22px; }
    .lp-drink-txt { flex: 1; min-width: 0; }
    .lp-drink-txt strong { display: block; font-size: 14px; }
    .lp-drink-txt small { color: var(--muted); font-size: 12px; }
    .lp-drink .lp-price { font-size: 18px; font-weight: 800; color: var(--brand); }
    .lp-empty { padding: 40px; text-align: center; color: var(--muted); background: #fff; border: 1px dashed var(--line); border-radius: 16px; }

    /* racik */
    .lp-racik { display: grid; grid-template-columns: 1.55fr 1fr; gap: 20px; margin-top: 30px; }
    .lp-box { background: #fff; border-radius: 16px; padding: 24px 26px; box-shadow: 0 6px 20px rgba(80, 40, 20, .05); }
    .lp-box-title { display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 15px; margin-bottom: 18px; }
    .lp-box-title .ico { color: var(--brand); }
    .lp-lv { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; }
    .lp-lv button { border: 0; border-radius: 10px; padding: 14px 0; font-weight: 800; font-size: 15px; background: #fbe9d3; color: #5a3b2e; transition: .15s; }
    .lp-lv button.hot { background: var(--brand); color: #fff; }
    .lp-lv button.on { box-shadow: 0 0 0 3px #fff, 0 0 0 5px var(--ink); }
    .lp-lv-cap { display: flex; justify-content: space-between; margin-top: 12px; font-size: 11.5px; color: var(--muted); }
    .lp-lv-cap b { color: var(--brand); font-weight: 600; }
    .lp-lv-help { margin-top: 18px; font-size: 12px; color: var(--muted); }
    .lp-top { display: flex; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid #f3e8da; font-size: 13px; }
    .lp-top:last-child { border-bottom: 0; }
    .lp-top b { color: var(--brand); font-weight: 700; }

    /* cara pesan */
    .lp-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 36px; margin-top: 34px; }
    .lp-step-no { display: inline-grid; place-items: center; width: 40px; height: 34px; border-radius: 9px; background: #fdeae4; color: var(--brand); font-weight: 800; font-size: 12px; margin-bottom: 16px; }
    .lp-step h3 { font-size: 16px; font-weight: 800; }
    .lp-step p { margin-top: 6px; font-size: 13px; color: var(--muted); max-width: 320px; }

    /* ambil / antar */
    .lp-pickup { display: grid; grid-template-columns: 1.1fr 1fr 1fr; gap: 20px; align-items: center; }
    .lp-pick { background: var(--bg); border: 1px solid var(--line); border-radius: 18px; padding: 24px; }
    .lp-pick-ico { display: inline-grid; place-items: center; width: 38px; height: 38px; border-radius: 10px; background: #fdeae4; color: var(--brand); margin-bottom: 38px; }
    .lp-pick h3 { font-size: 17px; font-weight: 800; }
    .lp-pick p { margin-top: 6px; font-size: 13px; color: var(--muted); }
    .lp-pick small { display: block; margin-top: 14px; font-size: 12px; font-weight: 700; color: var(--brand); }

    /* tentang */
    .lp-about { display: grid; grid-template-columns: 1.05fr 1fr; gap: 56px; align-items: center; }
    .lp-about-img { position: relative; border-radius: 24px; overflow: hidden; aspect-ratio: 4 / 3; box-shadow: var(--shadow); background: var(--soft); }
    .lp-about-img img, .lp-about-img .ph { width: 100%; height: 100%; object-fit: cover; }
    .lp-about-tag { position: absolute; left: 18px; bottom: 18px; background: #fff; border-radius: 999px; padding: 9px 18px; font-size: 12px; font-weight: 700; box-shadow: 0 6px 16px rgba(60, 30, 10, .14); }
    .lp-about p { margin-top: 14px; color: var(--muted); font-size: 14.5px; max-width: 480px; }
    .lp-about .lp-red { color: var(--brand); font-weight: 800; }

    /* info */
    .lp-info { background: #fdf0e0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
    .lp-info-in { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; padding-top: 22px; padding-bottom: 22px; }
    .lp-info-in > div { display: flex; align-items: flex-start; gap: 12px; }
    .lp-info-in .ico { color: var(--brand); width: 20px; height: 20px; margin-top: 2px; }
    .lp-info-in strong { display: block; font-size: 13.5px; }
    .lp-info-in small { color: var(--muted); font-size: 12px; }

    /* faq */
    .lp-faq-grid { display: grid; grid-template-columns: 1fr 1.7fr; gap: 56px; align-items: start; }
    .lp-faq details { border-bottom: 1px solid var(--line); padding: 18px 0; }
    .lp-faq details:first-child { padding-top: 4px; }
    .lp-faq summary { list-style: none; cursor: pointer; display: flex; justify-content: space-between; gap: 16px; font-weight: 800; font-size: 14.5px; }
    .lp-faq summary::-webkit-details-marker { display: none; }
    .lp-faq summary::after { content: '+'; color: var(--brand); font-weight: 700; }
    .lp-faq details[open] summary::after { content: '\2014'; }
    .lp-faq p { margin-top: 8px; font-size: 13px; color: var(--muted); max-width: 520px; }

    /* ajakan akhir */
    .lp-cta { display: grid; grid-template-columns: 1fr 1fr; background: var(--brand); border-radius: 26px; overflow: hidden; margin-bottom: 72px; }
    .lp-cta-txt { padding: 52px 48px; color: #fff; display: flex; flex-direction: column; align-items: flex-start; justify-content: center; }
    .lp-cta-txt .lp-eyebrow { color: #ffd9cf; }
    .lp-cta-txt h2 { color: #fff; font-size: 32px; }
    .lp-cta-txt p { margin: 10px 0 24px; color: #ffe3dc; font-size: 14.5px; }
    .lp-cta-img { min-height: 260px; background: #a83320; }
    .lp-cta-img img, .lp-cta-img .ph { width: 100%; height: 100%; object-fit: cover; }

    /* footer */
    .lp-foot { background: #fff; border-top: 1px solid var(--line); }
    .lp-foot-grid { display: grid; grid-template-columns: 1.6fr 1fr 1fr 1fr; gap: 32px; padding-top: 44px; padding-bottom: 30px; }
    .lp-foot-brand p { margin-top: 14px; font-size: 12.5px; color: var(--muted); }
    .lp-foot h4 { font-size: 13px; margin-bottom: 12px; }
    .lp-foot-grid a { display: block; font-size: 12.5px; color: var(--muted); margin-bottom: 9px; }
    .lp-foot-grid a:hover { color: var(--brand); }
    .lp-foot-grid a.red { color: var(--brand); font-weight: 700; }
    .lp-foot-grid p.t { font-size: 12.5px; color: var(--muted); }
    .lp-foot-grid p.t strong { color: var(--ink); font-size: 13px; }
    .lp-foot-bottom { display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap; padding-top: 18px; padding-bottom: 22px; border-top: 1px solid var(--line); font-size: 12px; color: var(--muted); }

    @media (max-width: 1020px) {
        .lp-menu-grid { grid-template-columns: repeat(2, 1fr); }
        .lp-pickup { grid-template-columns: 1fr 1fr; }
        .lp-pickup > div:first-child { grid-column: 1 / -1; }
    }
    @media (max-width: 860px) {
        .lp-hero h1 { font-size: 40px; }
        .lp-hero-grid, .lp-racik, .lp-about, .lp-faq-grid, .lp-cta { grid-template-columns: 1fr; gap: 28px; }
        .lp-strip-in { grid-template-columns: 1fr 1fr; }
        .lp-strip-in div { justify-content: flex-start; }
        .lp-steps, .lp-info-in { grid-template-columns: 1fr; gap: 22px; }
        .lp-sec { padding: 52px 0; }
        .lp-cta-txt { padding: 36px 26px; }
        .lp-foot-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 560px) {
        .lp-menu-grid, .lp-pickup { grid-template-columns: 1fr; }
        .lp h2 { font-size: 28px; }
        .lp-foot-grid { grid-template-columns: 1fr; }
        .lp-drink { flex-wrap: wrap; }
    }
</style>
@endpush

@section('content')
@php
    // Foto: unggah foto menu lewat Admin > Menu Seblak. Foto lain taruh di public/images/
    //   hero.jpg (opsional), tentang.jpg, cta.jpg (opsional)
    $img = fn ($file) => file_exists(public_path('images/' . $file)) ? asset('images/' . $file) : null;
    $rp  = fn ($angka) => 'Rp' . number_format((float) $angka, 0, ',', '.');

    $tautMenu    = Route::has('katalog.index') ? route('katalog.index') : '#menu';
    $menuPertama = $menus->first();

    $badge = ['Pilihan favorit', 'Klasik sejuta umat', 'Empuk & gurih', 'Gurihnya komplit'];

    // Topping yang ditampilkan di desain: Bakso, Sosis, Ceker, Mozzarella
    $urutanTopping = ['Bakso', 'Sosis', 'Ceker', 'Mozzarella'];
    $toppingTampil = collect($urutanTopping)
        ->map(fn ($n) => $toppings->firstWhere('nama_topping', $n))
        ->filter();
    if ($toppingTampil->isEmpty()) {
        $toppingTampil = $toppings->take(4);
    }
@endphp

<div class="lp">

{{-- ========== HERO ========== --}}
<section class="lp-hero">
    <div class="wrap lp-hero-grid">
        <div>
            <span class="lp-eyebrow">Seblak hangat, hari jadi nikmat</span>
            <h1>Lagi pengin pedas?<em>Nashwa-in aja.</em></h1>
            <p class="lp-lead">Semangkuk hangat dengan topping pilihanmu. Racik seblak sesukamu, dari pedas santai sampai level 5.</p>

            <div class="btn-row">
                <a href="{{ $tautMenu }}" class="btn btn-primary">Pesan Sekarang <x-icon name="arrow-right" /></a>
                <a href="#menu" class="btn btn-ghost">Lihat Menu</a>
            </div>

            @if ($hargaMulai)
                <p class="lp-note"><x-icon name="receipt" /> <span>Nikmatnya mulai <strong>{{ $rp($hargaMulai) }}</strong></span></p>
            @endif
        </div>

        <div class="lp-hero-card">
            <x-foto :src="$menuPertama?->fotoUrl() ?? $img('hero.jpg')" alt="Semangkuk seblak" />

            @if ($menuPertama)
                <div class="lp-hero-tag">
                    <div>
                        <strong>{{ $menuPertama->nama_menu }}</strong>
                        <small>{{ \Illuminate\Support\Str::limit($menuPertama->deskripsi, 48) }}</small>
                    </div>
                    <span class="lp-price">{{ $rp($menuPertama->harga) }}</span>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ========== JALUR KEUNGGULAN ========== --}}
<section class="lp-strip">
    <div class="wrap lp-strip-in">
        <div><x-icon name="bowl" /> Dimasak saat dipesan</div>
        <div><x-icon name="flame" /> Level pedas 0–5</div>
        <div>
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3v8a2 2 0 0 0 2 2v8"/><path d="M5 3v6"/><path d="M9 3v6"/><path d="M17 3c-2 2-3 5-3 8h3v10"/></svg>
            Topping sesuai selera
        </div>
        <div><x-icon name="bike" /> Ambil atau antar</div>
    </div>
</section>

{{-- ========== MENU ========== --}}
<section class="lp-sec" id="menu">
    <div class="wrap">
        <div class="lp-head">
            <div>
                <span class="lp-eyebrow">Pilihan Seblak Nashwa</span>
                <h2>Mau seblak yang mana?</h2>
                <p class="lp-sub">Pilih varianmu, lalu buat rasanya jadi lebih kamu.</p>
            </div>
            <a href="{{ $tautMenu }}" class="lp-more">Lihat semua menu di pemesanan <x-icon name="arrow-right" /></a>
        </div>

        @if ($menus->isEmpty())
            <div class="lp-empty">Menu belum tersedia. Jalankan <code>php artisan db:seed --class=KedaiSeeder</code>.</div>
        @else
            <div class="lp-menu-grid">
                @foreach ($menus as $menu)
                    <a class="lp-card" href="{{ Route::has('katalog.show') ? route('katalog.show', $menu->id_menu) : $tautMenu }}">
                        <div class="lp-card-img">
                            <x-foto :src="$menu->fotoUrl()" :alt="$menu->nama_menu" />
                            @if (isset($badge[$loop->index]))
                                <span class="lp-badge">{{ $badge[$loop->index] }}</span>
                            @endif
                        </div>
                        <div class="lp-card-body">
                            <h3>{{ $menu->nama_menu }}</h3>
                            <p>{{ $menu->deskripsi }}</p>
                            <div class="lp-card-foot">
                                <strong>{{ $rp($menu->harga) }}</strong>
                                <x-icon name="arrow-up-right" />
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        @if ($minuman)
            <div class="lp-drink">
                <div class="lp-drink-img"><x-foto :src="$minuman->fotoUrl()" :alt="$minuman->nama_menu" /></div>
                <div class="lp-drink-txt">
                    <strong>Teman makan pedas: {{ $minuman->nama_menu }}</strong>
                    <small>{{ $minuman->deskripsi }} Tersedia di menu pemesanan.</small>
                </div>
                <span class="lp-price">{{ $rp($minuman->harga) }}</span>
            </div>
        @endif
    </div>
</section>

{{-- ========== LEVEL PEDAS & TOPPING ========== --}}
<section class="lp-sec lp-peach" id="racik">
    <div class="wrap">
        <span class="lp-eyebrow">Satu mangkuk, banyak pilihan</span>
        <h2>Pedasnya kamu atur. Toppingnya kamu pilih.</h2>
        <p class="lp-sub">Sesuaikan level pedas dan tambahan topping saat memilih seblak di halaman pemesanan.</p>

        <div class="lp-racik">
            <div class="lp-box">
                <div class="lp-box-title"><x-icon name="flame" /> Dari level 0 sampai 5</div>

                <div class="lp-lv" id="lp-lv">
                    @for ($i = 0; $i <= 5; $i++)
                        <button type="button" class="{{ $i >= 3 ? 'hot' : '' }} {{ $i === 3 ? 'on' : '' }}" aria-pressed="{{ $i === 3 ? 'true' : 'false' }}">{{ $i }}</button>
                    @endfor
                </div>

                <div class="lp-lv-cap"><span>Lebih santai</span><b>Lebih menantang</b></div>
                <p class="lp-lv-help">Baru mencoba? Mulai dari level rendah, lalu temukan pedas yang paling pas untukmu.</p>
            </div>

            <div class="lp-box">
                <div class="lp-box-title">Biar makin rame</div>

                @forelse ($toppingTampil as $topping)
                    <div class="lp-top">
                        <span>{{ $topping->nama_topping }}</span>
                        <b>+{{ $rp($topping->harga) }}</b>
                    </div>
                @empty
                    <p class="lp-sub" style="margin:0">Topping belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ========== CARA PESAN ========== --}}
<section class="lp-sec" id="cara-pesan">
    <div class="wrap">
        <span class="lp-eyebrow">Cara pesan</span>
        <h2>Dari pilih menu sampai siap dinikmati.</h2>

        <div class="lp-steps">
            <div class="lp-step">
                <span class="lp-step-no">01</span>
                <h3>Pilih seblakmu</h3>
                <p>Buka halaman pemesanan dan pilih varian seblak yang kamu inginkan.</p>
            </div>
            <div class="lp-step">
                <span class="lp-step-no">02</span>
                <h3>Racik sesuai selera</h3>
                <p>Atur level pedas, pilih topping tambahan, dan tambahkan minuman.</p>
            </div>
            <div class="lp-step">
                <span class="lp-step-no">03</span>
                <h3>Tentukan cara terima</h3>
                <p>Pilih ambil di kedai atau pengantaran, lalu lanjutkan pembayaran.</p>
            </div>
        </div>
    </div>
</section>

{{-- ========== AMBIL / ANTAR ========== --}}
<section class="lp-sec" style="padding:56px 0">
    <div class="wrap lp-pickup">
        <div>
            <span class="lp-eyebrow">Nikmati dengan caramu</span>
            <h2>Mampir ke kedai atau tunggu di rumah.</h2>
            <p class="lp-sub">Pilih cara menerima pesanan yang paling nyaman untukmu saat memesan.</p>
        </div>

        <div class="lp-pick">
            <span class="lp-pick-ico">
                <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 9l1.5-5h13L20 9"/><path d="M4 9a2.5 2.5 0 0 0 5 0 2.5 2.5 0 0 0 5 0 2.5 2.5 0 0 0 5 0"/><path d="M5 12v8h14v-8"/><path d="M10 20v-4h4v4"/></svg>
            </span>
            <h3>Ambil di kedai</h3>
            <p>Pesan lewat web, lalu ambil pesananmu di kedai.</p>
            <small>Pilih opsi ambil di kedai</small>
        </div>

        <div class="lp-pick">
            <span class="lp-pick-ico"><x-icon name="bike" /></span>
            <h3>Pengantaran</h3>
            <p>Nikmati seblak tanpa harus keluar rumah.</p>
            <small>Biaya antar dihitung saat pembayaran</small>
        </div>
    </div>
</section>

{{-- ========== TENTANG ========== --}}
<section class="lp-sec" id="tentang">
    <div class="wrap lp-about">
        <div class="lp-about-img">
            <x-foto :src="$img('tentang.jpg')" alt="Seblak Nashwa" />
            <span class="lp-about-tag">Dibuat hangat, disajikan sepenuh hati.</span>
        </div>

        <div>
            <span class="lp-eyebrow">Kenalan dengan Nashwa</span>
            <h2>Kedai lokal untuk<br>selera pedasmu.</h2>
            <p>Seblak Nashwa adalah kedai UMKM dengan pilihan seblak yang bisa kamu racik sesuai selera. Dari Original hingga Komplit, setiap mangkuk dimasak saat dipesan.</p>
            <p>Buat kami, menikmati seblak itu sederhana: pilih yang kamu suka, atur pedasnya, lalu nikmati selagi hangat.</p>
            <p class="lp-red">Pedasnya pas, nagihnya jelas.</p>
        </div>
    </div>
</section>

{{-- ========== INFO ========== --}}
<section class="lp-info">
    <div class="wrap lp-info-in">
        <div>
            <x-icon name="clock" />
            <span><strong>Jam layanan</strong><small>Setiap hari, 10.00–21.00 WIB</small></span>
        </div>
        <div>
            <x-icon name="bowl" />
            <span><strong>Dimasak saat dipesan</strong><small>Pilih menu dan racikan di pemesanan.</small></span>
        </div>
        <div>
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v5"/><path d="M12 8h.01"/></svg>
            <span><strong>Rincian biaya</strong><small>Biaya layanan dan antar dihitung saat pembayaran.</small></span>
        </div>
    </div>
</section>

{{-- ========== FAQ ========== --}}
<section class="lp-sec" id="faq">
    <div class="wrap lp-faq-grid">
        <div>
            <span class="lp-eyebrow">Sebelum kamu pesan</span>
            <h2>Masih penasaran?</h2>
            <p class="lp-sub">Ini beberapa hal yang perlu kamu tahu sebelum menikmati Seblak Nashwa.</p>
        </div>

        <div class="lp-faq">
            <details open>
                <summary>Bisa pilih level pedas sendiri?</summary>
                <p>Bisa. Pilih level 0–5 saat memilih seblak di halaman pemesanan.</p>
            </details>
            <details open>
                <summary>Apa saja topping tambahannya?</summary>
                <p>Ada bakso, sosis, dan ceker masing-masing {{ $rp(optional($toppings->firstWhere('nama_topping', 'Bakso'))->harga ?? 3000) }}, serta mozzarella {{ $rp(optional($toppings->firstWhere('nama_topping', 'Mozzarella'))->harga ?? 5000) }}.</p>
            </details>
            <details open>
                <summary>Bisa ambil di kedai atau diantar?</summary>
                <p>Keduanya tersedia. Pilih cara menerima pesanan saat melanjutkan pembayaran.</p>
            </details>
            <details open>
                <summary>Berapa biaya pengantarannya?</summary>
                <p>Biaya layanan dan pengantaran dihitung saat pembayaran. Cek rinciannya sebelum menyelesaikan pesanan.</p>
            </details>
            <details open>
                <summary>Kapan saya bisa memesan?</summary>
                <p>Jam layanan kedai setiap hari, pukul 10.00–21.00 WIB.</p>
            </details>
        </div>
    </div>
</section>

{{-- ========== AJAKAN AKHIR ========== --}}
<section class="wrap">
    <div class="lp-cta">
        <div class="lp-cta-txt">
            <span class="lp-eyebrow">Sudah kebayang nikmatnya?</span>
            <h2>Yuk, Nashwa-in harimu.</h2>
            <p>Pilih seblak, racik seleramu, dan pesan sekarang.</p>
            <a href="{{ $tautMenu }}" class="btn btn-light">Pesan Sekarang <x-icon name="arrow-right" /></a>
        </div>
        <div class="lp-cta-img">
            <x-foto :src="$img('cta.jpg') ?? $menuPertama?->fotoUrl() ?? $img('hero.jpg')" alt="Seblak Nashwa" />
        </div>
    </div>
</section>

</div>
@endsection

{{-- ========== FOOTER (sesuai desain) ========== --}}
@section('footer')
<footer class="lp-foot">
    <div class="wrap lp-foot-grid">
        <div class="lp-foot-brand">
            <a href="{{ route('home') }}" class="brand">
                <span class="brand-ico"><x-icon name="bowl" /></span>
                <span class="brand-txt">
                    <strong>Seblak Nashwa</strong>
                    <small>PEDASNYA PAS, NAGIHNYA JELAS.</small>
                </span>
            </a>
            <p>Dibuat hangat, disajikan sepenuh hati.<br>Seblak pilihanmu, dengan pedas yang pas untukmu.</p>
        </div>

        <div>
            <h4>Jelajahi</h4>
            <a href="#menu">Menu pilihan</a>
            <a href="#cara-pesan">Cara pesan</a>
            <a href="#tentang">Tentang kedai</a>
            <a href="#faq">FAQ</a>
        </div>

        <div>
            <h4>Untuk kamu</h4>
            <a href="{{ $tautMenu }}" class="red">Pesan Sekarang ↗</a>
            <a href="{{ route('login') }}">Masuk / Daftar</a>
            <a href="#faq">Bantuan pemesanan</a>
        </div>

        <div>
            <h4>Jam layanan</h4>
            <p class="t">Setiap hari<br><strong>10.00–21.00 WIB</strong></p>
        </div>
    </div>

    <div class="wrap lp-foot-bottom">
        <span>© {{ date('Y') }} Seblak Nashwa. Pedasnya pas, nagihnya jelas.</span>
        <span>Kebijakan privasi</span>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    (function () {
        var tombol = document.querySelectorAll('#lp-lv button');
        tombol.forEach(function (btn) {
            btn.addEventListener('click', function () {
                tombol.forEach(function (b) {
                    var aktif = b === btn;
                    b.classList.toggle('on', aktif);
                    b.setAttribute('aria-pressed', aktif ? 'true' : 'false');
                });
            });
        });
    })();
</script>
@endpush
