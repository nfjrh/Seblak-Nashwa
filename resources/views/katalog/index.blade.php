@extends('layouts.app')
@section('title', 'Menu')

@push('styles')
<style>
    .kat-filter { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 28px; }
    .kat-filter a { padding: 9px 18px; border-radius: 999px; border: 1px solid var(--line); background: #fff; font-weight: 700; font-size: 14px; }
    .kat-filter a.on, .kat-filter a:hover { background: var(--brand); border-color: var(--brand); color: #fff; }
    .menu-card.habis { opacity: .6; }
    .tag-habis { font-size: 12px; font-weight: 800; color: var(--muted); }
    @media (max-width: 1020px) { .kat-grid { grid-template-columns: repeat(2, 1fr) !important; } }
    @media (max-width: 560px)  { .kat-grid { grid-template-columns: 1fr !important; } }
</style>
@endpush

@section('content')
<section class="sec">
    <div class="wrap">
        <div class="sec-head">
            <div>
                <span class="eyebrow">DAFTAR MENU</span>
                <h2>Mau seblak yang mana?</h2>
                <p class="sub">Pilih menu, lalu atur level pedas dan topping-nya.</p>
            </div>
        </div>

        <div class="kat-filter">
            <a href="{{ route('katalog.index') }}" class="{{ request('kategori') ? '' : 'on' }}">Semua</a>
            @foreach ($kategori as $k)
                <a href="{{ route('katalog.index', ['kategori' => $k->id_kategori]) }}"
                   class="{{ request('kategori') == $k->id_kategori ? 'on' : '' }}">{{ $k->nama_kategori }}</a>
            @endforeach
        </div>

        @if ($menu->isEmpty())
            <div class="kosong">Belum ada menu.</div>
        @else
            <div class="menu-grid kat-grid">
                @foreach ($menu as $m)
                    <a class="menu-card {{ $m->status == 'tersedia' ? '' : 'habis' }}" href="{{ route('katalog.show', $m->id_menu) }}">
                        <div class="media media-card">
                            <x-foto :src="$m->fotoUrl()" :alt="$m->nama_menu" />
                        </div>
                        <div class="menu-body">
                            <h3>{{ $m->nama_menu }}</h3>
                            <p>{{ $m->deskripsi }}</p>
                            <div class="menu-foot">
                                <strong>Rp {{ number_format($m->harga, 0, ',', '.') }}</strong>
                                @if ($m->status == 'tersedia')
                                    <span class="go"><x-icon name="arrow-up-right" /></span>
                                @else
                                    <span class="tag-habis">HABIS</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
