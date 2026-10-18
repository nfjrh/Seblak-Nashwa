<div class="field">
    <label for="nama_kategori">Nama Kategori</label>
    <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}">
    @error('nama_kategori') <div class="field-error">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('kategori.index') }}" class="btn">Batal</a>
