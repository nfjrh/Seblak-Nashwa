{{-- Isi menu samping panel admin. Dipakai di sidebar (layar lebar) dan offcanvas (HP). --}}
@php
    $aktifJumlah = \App\Models\Pesanan::statusAktif()->count();
    $navAdmin = [
        ['Ringkasan',         'bi-grid',       'admin.dashboard',      ['admin.dashboard']],
        ['Pesanan',           'bi-receipt',    'admin.pesanan.index',  ['admin.pesanan.*']],
        ['Kelola menu',       'bi-egg-fried',  'menu.index',           ['menu.*']],
        ['Kelola topping',    'bi-layers',     'admin.topping.index',  ['admin.topping.*']],
        ['Kategori',          'bi-tags',       'kategori.index',       ['kategori.*']],
        ['Level pedas',       'bi-fire',       'admin.level.index',    ['admin.level.*']],
        ['Laporan penjualan', 'bi-bar-chart',  'admin.laporan.index',  ['admin.laporan.*']],
        ['Pengaturan kedai',  'bi-gear',       'admin.pengaturan',     ['admin.pengaturan']],
    ];
@endphp

<a href="{{ route('admin.dashboard') }}" class="nw-brand mb-3">
    <span class="nw-brand-ico"><i class="bi bi-cup-hot-fill"></i></span>
    <span><strong>Seblak Nashwa</strong><small>RUANG PENGELOLA</small></span>
</a>

<div class="pn-label">Ruang pengelola</div>
@foreach ($navAdmin as [$label, $ikon, $rute, $pola])
    @if (Route::has($rute))
        <a href="{{ route($rute) }}" class="pn-link {{ request()->routeIs(...$pola) ? 'active' : '' }}">
            <i class="bi {{ $ikon }}"></i> {{ $label }}
            @if ($rute === 'admin.pesanan.index' && $aktifJumlah > 0)<span class="pn-n">{{ $aktifJumlah }}</span>@endif
        </a>
    @endif
@endforeach

<div class="mt-auto pt-4">
    <a href="{{ route('home') }}" class="pn-link"><i class="bi bi-box-arrow-up-right"></i> Lihat website</a>
    <form action="{{ route('admin.logout') }}" method="POST" class="mt-1">
        @csrf
        <button type="submit" class="pn-link text-danger"><i class="bi bi-box-arrow-left"></i> Keluar</button>
    </form>
    <div class="d-flex align-items-center gap-2 px-2 pt-3 small">
        <span class="nw-avatar">{{ mb_strtoupper(mb_substr(auth()->user()->nama ?? 'A', 0, 1)) }}</span>
        <div class="lh-sm"><strong>{{ auth()->user()->nama ?? 'Admin' }}</strong><div class="text-muted" style="font-size:.7rem">Pengelola kedai</div></div>
    </div>
</div>
