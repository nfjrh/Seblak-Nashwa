<div class="field">
    <label for="id_kategori">Kategori</label>
    <select id="id_kategori" name="id_kategori">
        <option value="">-- Pilih kategori --</option>
        @foreach ($kategori as $k)
            <option value="{{ $k->id_kategori }}"
                {{ old('id_kategori', $menu->id_kategori ?? '') == $k->id_kategori ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>
    @error('id_kategori') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="nama_menu">Nama Menu</label>
    <input type="text" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu ?? '') }}">
    @error('nama_menu') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="deskripsi">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="harga">Harga (Rp)</label>
    <input type="number" id="harga" name="harga" min="0" step="500" value="{{ old('harga', isset($menu) ? (int) $menu->harga : '') }}">
    @error('harga') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="status">Status</label>
    <select id="status" name="status">
        <option value="tersedia" {{ old('status', $menu->status ?? 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="habis" {{ old('status', $menu->status ?? '') == 'habis' ? 'selected' : '' }}>Habis</option>
    </select>
    @error('status') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="gambar">Gambar</label>
    @if (isset($menu) && $menu->fotoUrl())
        <div style="margin-bottom:10px">
            <img src="{{ $menu->fotoUrl() }}" alt="" style="width:140px;border-radius:10px">
        </div>
    @endif
    <input type="file" id="gambar" name="gambar" accept="image/*">
    @error('gambar') <div class="field-error">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('menu.index') }}" class="btn">Batal</a>
