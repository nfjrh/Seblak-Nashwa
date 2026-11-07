<div id="flash-pesan" class="d-none"
     data-status="{{ session('status') }}"
     data-galat="{{ session('galat') }}"></div>

<script>
    const toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2800, timerProgressBar: true });

    // Pesan sukses atau gagal dari Controller: ->with('status', ...) dan ->with('galat', ...)
    const flash = document.getElementById('flash-pesan');
    if (flash.dataset.status) { toast.fire({ icon: 'success', title: flash.dataset.status }); }
    if (flash.dataset.galat)  { toast.fire({ icon: 'error',   title: flash.dataset.galat }); }

    // Form dengan class "form-konfirmasi" meminta persetujuan dulu sebelum dikirim.
    // Atur teksnya lewat data-judul, data-teks, dan data-tombol.
    document.querySelectorAll('form.form-konfirmasi').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: form.dataset.judul || 'Yakin?',
                text: form.dataset.teks || '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C63E2A',
                confirmButtonText: form.dataset.tombol || 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then(function (hasil) { if (hasil.isConfirmed) form.submit(); });
        });
    });

    // Tombol atau tautan dengan class "js-segera" menampilkan pesan fitur belum tersedia.
    document.querySelectorAll('.js-segera').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({ icon: 'info', title: 'Segera hadir', text: 'Fitur ini sedang disiapkan.', confirmButtonColor: '#C63E2A' });
        });
    });
</script>