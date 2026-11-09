@extends('layouts.panel')

@section('title', 'Pengaturan Kedai')
@section('heading', 'Pengaturan Kedai')
@section('subheading', 'Kelola identitas usaha, jam layanan, pembayaran, dan akun pengelola.')

@section('aksi')
    <span class="nw-badge {{ $pengaturan->kedai_buka ? 'nw-badge-hijau' : 'nw-badge-merah' }}">
        {{ $pengaturan->kedai_buka ? 'Kedai buka' : 'Kedai tutup' }}
    </span>
@endsection

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
@endphp

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show small" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.pengaturan.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-12 col-xl-7">
            <!-- Profil Usaha -->
            <div class="nw-card p-3 p-md-4 mb-4">
                <h2 class="h5 mb-3">Profil usaha</h2>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Nama kedai</label>
                        <input type="text" name="nama_kedai" class="form-control" value="{{ old('nama_kedai', $pengaturan->nama_kedai) }}" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $pengaturan->tagline) }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Nomor WhatsApp usaha</label>
                        <input type="text" name="nomor_whatsapp" class="form-control" value="{{ old('nomor_whatsapp', $pengaturan->nomor_whatsapp) }}" placeholder="Contoh: 081234567890">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Email usaha</label>
                        <input type="email" name="email_kedai" class="form-control" value="{{ old('email_kedai', $pengaturan->email_kedai) }}" placeholder="Contoh: admin@seblaknashwa.test">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat kedai</label>
                        <textarea name="alamat_kedai" class="form-control" rows="2" placeholder="Masukkan alamat lengkap kedai">{{ old('alamat_kedai', $pengaturan->alamat_kedai) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Jam Buka -->
            <div class="nw-card p-3 p-md-4">
                <h2 class="h5 mb-3">Jam buka</h2>
                <div class="table-responsive">
                    <table class="table pn-table align-middle mb-0">
                        <thead><tr><th>Hari</th><th>Aktif</th><th>Buka</th><th>Tutup</th></tr></thead>
                        <tbody>
                            @foreach ($hari as $h)
                                <tr>
                                    <td>{{ $h }}</td>
                                    <td><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" checked></div></td>
                                    <td><input class="form-control form-control-sm" style="width:90px" value="10.00"></td>
                                    <td><input class="form-control form-control-sm" style="width:90px" value="21.00"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <!-- Status Operasional -->
            <div class="nw-card p-3 p-md-4 mb-4">
                <h2 class="h5 mb-3">Status operasional</h2>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div><strong>Kedai buka</strong><div class="small text-muted">Menerima pesanan masuk.</div></div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="kedai_buka" value="1" {{ $pengaturan->kedai_buka ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div><strong>Jeda pesanan sementara</strong><div class="small text-muted">Hentikan pesanan baru tanpa mengubah jadwal.</div></div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="jeda_pesanan" value="1" {{ $pengaturan->jeda_pesanan ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <!-- Layanan Pesanan -->
            <div class="nw-card p-3 p-md-4 mb-4">
                <h2 class="h5 mb-3">Layanan pesanan</h2>
                <div class="mb-3">
                    <label class="form-label small text-muted">Biaya layanan pengantaran (Rp)</label>
                    <input type="number" name="biaya_layanan" class="form-control form-control-sm" value="{{ old('biaya_layanan', $pengaturan->biaya_layanan) }}" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small text-muted">Ongkir (tarif tetap) (Rp)</label>
                    <input type="number" name="ongkir_tetap" class="form-control form-control-sm" value="{{ old('ongkir_tetap', $pengaturan->ongkir_tetap) }}" required>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="nw-card p-3 p-md-4">
                <h2 class="h5 mb-3">Metode pembayaran</h2>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small fw-semibold">QRIS / E-Wallet</span>
                    <div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="qris_aktif" value="1" {{ $pengaturan->qris_aktif ? 'checked' : '' }}></div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small fw-semibold">Transfer Bank</span>
                    <div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="transfer_aktif" value="1" {{ $pengaturan->transfer_aktif ? 'checked' : '' }}></div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small fw-semibold">Bayar di Tempat (COD)</span>
                    <div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="cod_aktif" value="1" {{ $pengaturan->cod_aktif ? 'checked' : '' }}></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Simpan -->
    <div class="nw-card p-3 mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <span class="small text-muted">Pastikan data sudah benar sebelum menyimpan.</span>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Simpan perubahan</button>
        </div>
    </div>
</form>
@endsection