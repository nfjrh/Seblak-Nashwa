@extends('layouts.app')
@section('title', $menu->nama_menu)

@push('styles')
<style>
    .detail { display: grid; grid-template-columns: 1fr 1fr; gap: 44px; align-items: start; }
    .detail-foto { border-radius: 22px; overflow: hidden; box-shadow: var(--shadow); aspect-ratio: 4 / 3; background: var(--soft); }
    .detail-foto img, .detail-foto .ph { width: 100%; height: 100%; object-fit: cover; display: flex; align-items: center; justify-content: center; font-size: 64px; }
    .detail h1 { font-size: 34px; margin: 8px 0; }
    .detail .harga { color: var(--brand); font-size: 26px; font-weight: 800; margin-bottom: 14px; }
    .detail .habis-info { background: #fff1d6; color: #8a5a00; padding: 12px 16px; border-radius: 10px; font-weight: 700; margin: 14px 0; }
    .detail .aksi { margin-top: 22px; }

    .opsi { margin-top: 24px; padding-top: 22px; border-top: 1px solid var(--line); }
    .opsi h3 { font-size: 14px; font-weight: 800; margin: 18px 0 10px; }
    .opsi h3:first-of-type { margin-top: 0; }
    .opsi-err { background: #fdeae4; color: #b42318; border: 1px solid #f3c9c0; border-radius: 10px; padding: 10px 14px; font-size: 13.5px; font-weight: 600; margin-bottom: 14px; }
    .opsi-grid { display: flex; flex-wrap: wrap; gap: 10px; }
    .opsi-grid label { cursor: pointer; }
    .opsi-grid input { position: absolute; opacity: 0; pointer-events: none; }
    .opsi-grid span { display: inline-block; border: 1.5px solid var(--line); border-radius: 12px; padding: 10px 14px; font-size: 13.5px; font-weight: 700; background: #fff; transition: .15s; }
    .opsi-grid span small { color: var(--muted); font-weight: 600; }
    .opsi-grid input:checked + span { border-color: var(--brand); background: #fdeae4; color: var(--brand); }
    .opsi-jml { width: 90px; padding: 11px 12px; border: 1px solid var(--line); border-radius: 12px; font: inherit; background: #fffaf3; }
    .opsi-btn { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-top: 22px; }
    @media (max-width: 860px) { .detail { grid-template-columns: 1fr; gap: 24px; } }
</style>
@endpush

@section('content')
@php
    $levels   = \App\Models\LevelPedas::orderBy('id_level')->get();
    $toppings = \App\Models\Topping::where('stok', '>', 0)->orderBy('nama_topping')->get();
    $levelAwal = old('id_level', optional($levels->firstWhere('nama_level', 'Level 3') ?? $levels->first())->id_level);
    $rp = fn ($angka) => 'Rp' . number_format((float) $angka, 0, ',', '.');
@endphp

<section class="sec">
    <div class="wrap">
        <div class="detail">
            <div class="detail-foto">
                <x-foto :src="$menu->fotoUrl()" :alt="$menu->nama_menu" />
            </div>

            <div>
                @if ($menu->kategori)
                    <span class="pill">{{ $menu->kategori->nama_kategori }}</span>
                @endif
                <h1>{{ $menu->nama_menu }}</h1>
                <div class="harga">{{ $rp($menu->harga) }}</div>
                <p>{{ $menu->deskripsi }}</p>

                @if ($menu->status != 'tersedia')
                    <div class="habis-info">Menu ini sedang habis.</div>
                @else
                    @auth
                        {{-- Pilihan level pedas dan topping, lalu masukkan ke keranjang --}}
                        <form action="{{ route('keranjang.tambah') }}" method="POST" class="opsi">
                            @csrf
                            <input type="hidden" name="id_menu" value="{{ $menu->id_menu }}">

                            @if ($errors->any())
                                <div class="opsi-err">@foreach ($errors->all() as $pesan) <div>{{ $pesan }}</div> @endforeach</div>
                            @endif

                            <h3>Level pedas</h3>
                            <div class="opsi-grid">
                                @foreach ($levels as $level)
                                    <label>
                                        <input type="radio" name="id_level" value="{{ $level->id_level }}" {{ (int) $levelAwal === (int) $level->id_level ? 'checked' : '' }}>
                                        <span>{{ $level->nama_level }}@if ($level->tambahan_harga > 0) <small>+{{ $rp($level->tambahan_harga) }}</small>@endif</span>
                                    </label>
                                @endforeach
                            </div>

                            <h3>Topping</h3>
                            <div class="opsi-grid">
                                @forelse ($toppings as $topping)
                                    <label>
                                        <input type="checkbox" name="topping[]" value="{{ $topping->id_topping }}" {{ in_array($topping->id_topping, (array) old('topping', [])) ? 'checked' : '' }}>
                                        <span>{{ $topping->nama_topping }} <small>+{{ $rp($topping->harga) }}</small></span>
                                    </label>
                                @empty
                                    <span class="muted">Belum ada topping tersedia.</span>
                                @endforelse
                            </div>

                            <h3>Jumlah</h3>
                            <input type="number" name="jumlah" class="opsi-jml" value="{{ old('jumlah', 1) }}" min="1" max="20">

                            <div class="opsi-btn">
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang <x-icon name="arrow-right" /></button>
                                <a href="{{ route('katalog.index') }}" class="btn btn-ghost">Kembali ke daftar menu</a>
                            </div>
                        </form>
                    @else
                        <div class="aksi">
                            <a href="{{ route('login') }}" class="btn btn-primary">Masuk untuk memesan <x-icon name="arrow-right" /></a>
                            <a href="{{ route('katalog.index') }}" class="btn btn-ghost">Kembali ke daftar menu</a>
                        </div>
                    @endauth
                @endif

                @if ($menu->status != 'tersedia')
                    <div class="aksi">
                        <a href="{{ route('katalog.index') }}" class="btn btn-ghost">Kembali ke daftar menu</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
