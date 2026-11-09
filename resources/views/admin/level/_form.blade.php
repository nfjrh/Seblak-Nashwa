@if ($errors->any())
    <div class="alert alert-danger small">
        <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="mb-3">
    <label for="nama_level" class="form-label">Nama level</label>
    <input type="text" id="nama_level" name="nama_level" class="form-control" value="{{ old('nama_level', $level->nama_level ?? '') }}">
</div>
<div class="mb-4">
    <label for="tambahan_harga" class="form-label">Tambahan harga (Rp)</label>
    <input type="number" id="tambahan_harga" name="tambahan_harga" min="0" step="500" class="form-control"
           value="{{ old('tambahan_harga', isset($level) ? (int) $level->tambahan_harga : 0) }}">
    <div class="form-text">Isi 0 kalau level ini gratis. Maksimal Rp{{ number_format(\App\Models\LevelPedas::TAMBAHAN_HARGA_MAKS, 0, ',', '.') }}.</div>
</div>

<button type="submit" class="btn btn-primary px-4">Simpan level</button>
<a href="{{ route('admin.level.index') }}" class="btn btn-outline-dark">Batal</a>