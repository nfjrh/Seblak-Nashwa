@props(['src' => null, 'alt' => ''])
@if ($src)
    <img src="{{ $src }}" alt="{{ $alt }}" loading="lazy">
@else
    {{-- gambar pengganti sampai foto asli dipasang --}}
    <div class="ph" role="img" aria-label="{{ $alt }}"><span>🍜</span></div>
@endif
