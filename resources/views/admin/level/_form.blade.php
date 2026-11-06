@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $pesan) <div>{{ $pesan }}</div> @endforeach
    </div>
@endif

<div class="field">
    <label for="nama_level">Nama Level</label>
    <input type="text" id="nama_level" name="nama_level" value="{{ old('nama_level', $level->nama_level ?? '') }}">
</div>
<div class="field">
    <label for="tambahan_harga">Tambahan Harga (Rp)</label>
    <input type="number" id="tambahan_harga" name="tambahan_harga" min="0" step="500"
           value="{{ old('tambahan_harga', isset($level) ? (int) $level->tambahan_harga : 0) }}">
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.level.index') }}" class="btn">Batal</a>
