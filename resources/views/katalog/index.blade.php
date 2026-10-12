@extends('anggota2.layout')
@section('title', 'Daftar Menu')
 
@section('content')
<h3 class="mb-3">Daftar Menu</h3>
 
<div class="mb-4">
    <a href="{{ route('katalog.index') }}"
       class="btn btn-sm {{ request('kategori') ? 'btn-outline-danger' : 'btn-danger' }}">Semua</a>
    @foreach ($kategori as $k)
        <a href="{{ route('katalog.index', ['kategori' => $k->id_kategori]) }}"
           class="btn btn-sm {{ request('kategori') == $k->id_kategori ? 'btn-danger' : 'btn-outline-danger' }}">
            {{ $k->nama_kategori }}
        </a>
    @endforeach
</div>
 
<div class="row">
    @forelse ($menu as $m)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                @if ($m->gambar)
                    <img src="{{ asset('storage/' . $m->gambar) }}" class="card-img-top"
                         style="height:180px; object-fit:cover">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $m->nama_menu }}</h5>
                    <p class="card-text text-danger fw-bold">
                        Rp {{ number_format($m->harga, 0, ',', '.') }}
                    </p>
                    @if ($m->status == 'tersedia')
                        <a href="{{ route('katalog.show', $m->id_menu) }}" class="btn btn-sm btn-danger">Lihat Detail</a>
                    @else
                        <span class="badge bg-secondary">Habis</span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p>Belum ada menu.</p>
    @endforelse
</div>
@endsection