@extends('layouts.pelanggan')

@section('title', $menu->nama_menu)

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $keterangan = ['Tidak pedas', 'Santai', 'Sedang', 'Pedas', 'Ekstra', 'Membara'];
    $habis = $menu->status !== 'tersedia';
@endphp
<div class="container py-4">
    <nav class="small mb-3">
        <a href="{{ route('katalog.index') }}" class="text-muted"><i class="bi bi-arrow-left text-danger"></i> Katalog menu</a>
        <span class="text-muted"> / </span><strong>{{ $menu->nama_menu }}</strong>
    </nav>

    <div class="row g-4">
        {{-- Kiri: foto dan ringkasan --}}
        <div class="col-12 col-lg-5">
            <div class="position-relative">
                <x-foto-menu :menu="$menu" rasio="1x1" class="rounded-4" />
                <span class="nw-badge position-absolute" style="top:1rem;left:1rem">{{ $habis ? 'Habis' : 'Pilihan favorit' }}</span>
            </div>
            <h1 class="display-6 fw-bold mt-3 mb-1">{{ $menu->nama_menu }}</h1>
            <div class="nw-price fs-3 mb-2">{{ $rp($menu->harga) }}</div>
            <p class="text-muted">{{ $menu->deskripsi }}</p>

            <div class="nw-card-soft p-3 small">
                <div class="fw-bold"><i class="bi bi-stopwatch text-danger me-1"></i> Dibuat setelah kamu pesan</div>
                <div class="text-muted">Estimasi masak 15–20 menit. Nikmati selagi hangat untuk rasa terbaik.</div>
            </div>
        </div>

        {{-- Kanan: kustomisasi --}}
        <div class="col-12 col-lg-7">
            @if ($menu->bisaDiracik())
                <h2 class="h3 mb-1">Racik sesuai seleramu</h2>
                <p class="text-muted">Sedikit pedas atau berani banget? Kamu yang pilih.</p>
            @else
                <h2 class="h3 mb-1">Siap dipesan</h2>
                <p class="text-muted">Tambahkan ke keranjang bersama seblak favoritmu.</p>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('keranjang.tambah') }}" method="POST" id="form-racik"
                  data-harga="{{ (float) $menu->harga }}" data-nama="{{ $menu->nama_menu }}">
                @csrf
                <input type="hidden" name="id_menu" value="{{ $menu->id_menu }}">

                {{-- Level pedas dan topping: hanya untuk menu yang bisa diracik (seblak) --}}
                @if ($menu->bisaDiracik())
                {{-- Level pedas --}}
                <div class="nw-card p-3 p-md-4 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 mb-0">Level pedas</h3>
                        <span class="nw-badge">Wajib · pilih 1</span>
                    </div>
                    <div class="row row-cols-3 row-cols-md-6 g-2">
                        @foreach ($levels as $i => $level)
                            @php $angka = \Illuminate\Support\Str::afterLast($level->nama_level, ' '); @endphp
                            <div class="col">
                                <input type="radio" class="btn-check" name="id_level" id="level{{ $level->id_level }}"
                                       value="{{ $level->id_level }}" data-tambah="{{ (float) $level->tambahan_harga }}"
                                       {{ (string) old('id_level') === (string) $level->id_level ? 'checked' : '' }}>
                                <label class="nw-opsi nw-level" for="level{{ $level->id_level }}">
                                    <b>{{ is_numeric($angka) ? $angka : $level->nama_level }}</b>
                                    <small>{{ $keterangan[$i] ?? '' }}</small>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Topping --}}
                <div class="nw-card p-3 p-md-4 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 mb-0">Tambah topping</h3>
                        <span class="small text-muted">Opsional · boleh lebih dari 1</span>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 g-2">
                        @forelse ($toppings as $t)
                            <div class="col">
                                <input type="checkbox" class="btn-check" name="topping[]" id="topping{{ $t->id_topping }}"
                                       value="{{ $t->id_topping }}" data-harga="{{ (float) $t->harga }}"
                                       {{ $t->stok <= 0 ? 'disabled' : '' }}
                                       {{ in_array($t->id_topping, (array) old('topping', [])) ? 'checked' : '' }}>
                                <label class="nw-opsi d-flex justify-content-between align-items-center" for="topping{{ $t->id_topping }}">
                                    <span class="fw-bold small">{{ $t->nama_topping }}@if ($t->stok <= 0) <span class="text-muted fw-normal">(habis)</span>@endif</span>
                                    <span class="small text-muted">+{{ $rp($t->harga) }}</span>
                                </label>
                            </div>
                        @empty
                            <div class="col-12 text-muted small">Belum ada topping tambahan.</div>
                        @endforelse
                    </div>
                </div>
                @endif

                {{-- Jumlah dan total --}}
                <div class="nw-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 mb-0">Jumlah porsi</h3>
                        <div class="nw-qty">
                            <button type="button" id="kurang" aria-label="Kurangi">−</button>
                            <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="20" readonly>
                            <button type="button" id="tambah" aria-label="Tambah">+</button>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <div class="small text-muted" id="rincian">{{ $menu->nama_menu }} {{ $rp($menu->harga) }}</div>
                            <div class="small text-muted">Total pesanan ini</div>
                            <div class="nw-price fs-3" id="total">{{ $rp($menu->harga) }}</div>
                        </div>
                        @auth
                            <button type="submit" class="btn btn-primary btn-lg px-4" {{ $habis ? 'disabled' : '' }}>
                                <i class="bi bi-bag-plus me-1"></i> {{ $habis ? 'Menu habis' : 'Tambah ke keranjang' }}
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">Masuk untuk memesan</a>
                        @endauth
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('form-racik');
        const jumlah = document.getElementById('jumlah');
        const rupiah = n => 'Rp' + Math.round(n).toLocaleString('id-ID');

        function hitung() {
            const dasar = parseFloat(form.dataset.harga);
            const level = form.querySelector('input[name="id_level"]:checked');
            const tambahLevel = level ? parseFloat(level.dataset.tambah) : 0;
            let tambahTopping = 0, banyak = 0;
            form.querySelectorAll('input[name="topping[]"]:checked').forEach(function (t) {
                tambahTopping += parseFloat(t.dataset.harga); banyak++;
            });
            const qty = parseInt(jumlah.value, 10) || 1;
            document.getElementById('total').textContent = rupiah((dasar + tambahLevel + tambahTopping) * qty);
            document.getElementById('rincian').textContent =
                form.dataset.nama + ' ' + rupiah(dasar) + (banyak ? ' + topping ' + rupiah(tambahTopping) : '') + ' · ' + qty + ' porsi';
        }

        document.getElementById('kurang').addEventListener('click', function () {
            jumlah.value = Math.max(1, (parseInt(jumlah.value, 10) || 1) - 1); hitung();
        });
        document.getElementById('tambah').addEventListener('click', function () {
            jumlah.value = Math.min(20, (parseInt(jumlah.value, 10) || 1) + 1); hitung();
        });
        form.addEventListener('change', hitung);
        hitung();
    })();
</script>
@endpush