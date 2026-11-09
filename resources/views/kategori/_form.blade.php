<div class="mb-4">
    <label for="nama_kategori" class="form-label">Nama kategori</label>
    <input type="text" id="nama_kategori" name="nama_kategori" maxlength="100"
           value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}"
           class="form-control @error('nama_kategori') is-invalid @enderror">
    @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<button type="submit" class="btn btn-primary px-4">Simpan</button>
<a href="{{ route('kategori.index') }}" class="btn btn-outline-dark">Batal</a>
