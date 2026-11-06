@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $pesan) <div>{{ $pesan }}</div> @endforeach
    </div>
@endif

<div class="field">
    <label for="nama_topping">Nama Topping</label>
    <input type="text" id="nama_topping" name="nama_topping" value="{{ old('nama_topping', $topping->nama_topping ?? '') }}">
</div>
<div class="field">
    <label for="harga">Harga (Rp)</label>
    <input type="number" id="harga" name="harga" min="0" step="500" value="{{ old('harga', isset($topping) ? (int) $topping->harga : '') }}">
</div>
<div class="field">
    <label for="stok">Stok</label>
    <input type="number" id="stok" name="stok" min="0" value="{{ old('stok', $topping->stok ?? 0) }}">
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.topping.index') }}" class="btn">Batal</a>
