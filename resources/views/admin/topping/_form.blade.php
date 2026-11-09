@if ($errors->any())
    <div class="alert alert-danger small">
        <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="mb-3">
    <label for="nama_topping" class="form-label">Nama topping</label>
    <input type="text" id="nama_topping" name="nama_topping" class="form-control" value="{{ old('nama_topping', $topping->nama_topping ?? '') }}">
</div>
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6">
        <label for="harga" class="form-label">Harga tambahan (Rp)</label>
        <input type="number" id="harga" name="harga" min="0" step="500" class="form-control" value="{{ old('harga', isset($topping) ? (int) $topping->harga : '') }}">
    </div>
    <div class="col-12 col-sm-6">
        <label for="stok" class="form-label">Stok tersedia (porsi)</label>
        <input type="number" id="stok" name="stok" min="0" class="form-control" value="{{ old('stok', $topping->stok ?? 0) }}">
        <div class="form-text">Stok {{ \App\Models\Topping::STOK_MENIPIS }} atau kurang ditandai menipis.</div>
    </div>
</div>

<button type="submit" class="btn btn-primary px-4">Simpan topping</button>
<a href="{{ route('admin.topping.index') }}" class="btn btn-outline-dark">Batal</a>