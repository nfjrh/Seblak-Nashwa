<div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror">
        <option value="">-- Pilih kategori --</option>
        @foreach ($kategori as $k)
            <option value="{{ $k->id_kategori }}"
                {{ old('id_kategori', $menu->id_kategori ?? '') == $k->id_kategori ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>
    @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
 
<div class="mb-3">
    <label class="form-label">Nama Menu</label>
    <input type="text" name="nama_menu"
           class="form-control @error('nama_menu') is-invalid @enderror"
           value="{{ old('nama_menu', $menu->nama_menu ?? '') }}">
    @error('nama_menu') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
 
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" rows="3"
              class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
 
<div class="mb-3">
    <label class="form-label">Harga (Rp)</label>
    <input type="number" name="harga" step="any"
           class="form-control @error('harga') is-invalid @enderror"
           value="{{ old('harga', isset($menu) ? (int) $menu->harga : '') }}">
    @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
 
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="tersedia"
            {{ old('status', $menu->status ?? 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="habis"
            {{ old('status', $menu->status ?? '') == 'habis' ? 'selected' : '' }}>Habis</option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
 
<div class="mb-3">
    <label class="form-label">Gambar</label>
    @if (!empty($menu->gambar))
        <div class="mb-2">
            <img src="{{ asset('storage/' . $menu->gambar) }}" width="120" class="rounded">
        </div>
    @endif
    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
    @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
 
<button class="btn btn-danger">Simpan</button>
<a href="{{ route('menu.index') }}" class="btn btn-secondary">Batal</a>