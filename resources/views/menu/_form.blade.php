@if ($errors->any())
    <div class="alert alert-danger small">
        <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="row g-4">
    <div class="col-12 col-md-5">
        <label class="form-label">Foto menu</label>
        <div id="kotak-foto" class="mb-2">
            @if (isset($menu))
                <x-foto-menu :menu="$menu" rasio="4x3" class="rounded-4" />
            @else
                <div class="nw-foto ratio ratio-4x3 rounded-4"><div class="d-flex align-items-center justify-content-center"><span>🍜</span></div></div>
            @endif
        </div>
        <img id="pratinjau" class="pn-preview d-none mb-2" alt="Pratinjau foto">
        <input type="file" id="gambar" name="gambar" accept="image/*" class="form-control">
        <div class="form-text">JPG atau PNG, maksimal 2 MB.</div>
    </div>

    <div class="col-12 col-md-7">
        <div class="mb-3">
            <label for="nama_menu" class="form-label">Nama menu</label>
            <input type="text" id="nama_menu" name="nama_menu" class="form-control" value="{{ old('nama_menu', $menu->nama_menu ?? '') }}">
        </div>
        <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select id="id_kategori" name="id_kategori" class="form-select">
                    <option value="">Pilih kategori</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}" {{ old('id_kategori', $menu->id_kategori ?? '') == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" min="0" step="500" class="form-control"
                       value="{{ old('harga', isset($menu) ? (int) $menu->harga : '') }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
            <div class="form-text">Tampil di kartu menu pelanggan.</div>
        </div>
        <div class="mb-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select">
                <option value="tersedia" {{ old('status', $menu->status ?? 'tersedia') === 'tersedia' ? 'selected' : '' }}>Tersedia (bisa dipesan)</option>
                <option value="habis" {{ old('status', $menu->status ?? '') === 'habis' ? 'selected' : '' }}>Habis</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check2 me-1"></i> Simpan menu</button>
        <a href="{{ route('menu.index') }}" class="btn btn-outline-dark">Batal</a>
    </div>
</div>

@push('scripts')
<script>
    // Pratinjau foto yang baru dipilih
    document.getElementById('gambar').addEventListener('change', function () {
        const berkas = this.files[0];
        const gambar = document.getElementById('pratinjau');
        if (!berkas) { gambar.classList.add('d-none'); return; }
        gambar.src = URL.createObjectURL(berkas);
        gambar.classList.remove('d-none');
        document.getElementById('kotak-foto').classList.add('d-none');
    });
</script>
@endpush