@props(['menu' => null, 'rasio' => '4x3', 'class' => ''])
{{-- Foto menu. Kalau belum ada foto, tampil gambar pengganti.
     Pemakaian: <x-foto-menu :menu="$menu" rasio="4x3" /> --}}
@php $url = $menu?->fotoUrl(); @endphp
<div class="nw-foto ratio ratio-{{ $rasio }} {{ $class }}">
    @if ($url)
        <img src="{{ $url }}" alt="{{ $menu->nama_menu }}" loading="lazy">
    @else
        <div class="d-flex align-items-center justify-content-center" role="img" aria-label="{{ $menu?->nama_menu }}"><span>🍜</span></div>
    @endif
</div>