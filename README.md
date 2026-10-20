# Seblak Nashwa: Website Penjualan dan Manajemen Pesanan

Website resmi untuk UMKM Seblak Nashwa. Pelanggan dapat melihat katalog menu seblak, melakukan kustomisasi tingkat kepedasan & topping, melakukan pemesanan online, serta melacak status pesanan secara real-time. Sementara itu, pemilik/admin dapat mengelola data produk, memantau pesanan masuk, dan melihat laporan penjualan dari satu sistem terintegrasi. Proyek ini dikerjakan sebagai tugas kelompok untuk memenuhi mata kuliah terkait.

## Tim Pengembang 
Berikut adalah daftar 5 orang anggota tim yang berpartisipasi dalam pengembangan proyek Seblak Nashwa:

| NIM | Nama | Peran |
| :--- | :--- | :--- |
| 250210501040 | Pasya Dwi Rama | - |
| 250210500029 | Nurul Fajrih | - |
| 250210500025 | Najwa Nur Asyifa | - |
| 250210500022 | Intan Nur Ilmi | - |
| 210210501036 | M. Alwi Shihab | - |

---

## Fitur Utama

Sistem ini membagi hak akses ke dalam 2 subjek utama berdasarkan rancangan antarmuka (UI/UX):

### 1. Pelanggan
Pelanggan merupakan pengguna umum yang dapat mengakses halaman katalog dan melakukan pemesanan dengan mudah:
* **Katalog & Detail Menu:** Menjelajahi berbagai varian menu seblak dengan informasi harga, deskripsi, dan ketersediaan stok.
* **Kustomisasi Pesanan:** Memilih tingkat kepedasan, porsi, serta tambahan aneka topping sesuai selera.
* **Keranjang & Checkout Online:** Mengelola produk di keranjang belanja, mengisi alamat pengiriman, dan memilih metode pembayaran.
* **Pelacakan Status Pesanan:** Memantau proses pesanan mulai dari konfirmasi, proses memasak, hingga siap diantar atau diambil di tempat.
* **Riwayat Transaksi:** Melihat kembali daftar pesanan yang pernah dibuat beserta detail statusnya.

### 2. Admin / Pemilik
Admin memiliki hak akses penuh untuk mengontrol operasional toko dan memantau performa penjualan secara keseluruhan:
* **Dashboard & Statistik:** Menampilkan ringkasan data penting, grafik penjualan harian/bulanan, dan total pendapatan secara visual.
* **Manajemen Menu & Produk:** Menambah, memperbarui, atau menghapus menu seblak, varian, dan ketersediaan topping.
* **Manajemen Pesanan Masuk:** Memantau daftar pesanan baru dan memperbarui status pesanan secara real-time.
* **Manajemen Laporan:** Melihat dan merekap data transaksi serta laporan keuangan toko.


## Tech Stack

| Bagian | Teknologi |
| :--- | :--- |
| **Framework** | Laravel |
| **Server Lokal** | Laravel Herd |
| **Database** | MySQL, dikelola dengan DBeaver |
| **Frontend** | - |
| **Desain UI/UX** | Figma |
| **Version Control** | Git dan GitHub |

---

## Aturan Sistem

* **Hak Akses Berdasarkan Peran:** Pelanggan fokus pada area belanja dan riwayat pribadi, sedangkan admin mengelola panel kontrol operasional.
* **Validasi Stok & Menu:** Produk yang kosong atau habis tidak dapat dipesan oleh pelanggan.
* **Desain Responsif:** Dibangun agar nyaman diakses melalui berbagai perangkat baik oleh pelanggan dari Seblak Nashwa maupun tim operasional Seblak Nashwa

---

## Cara Menjalankan Proyek (Local Development)

Prasyarat: Pastikan Laravel Herd, MySQL, Node.js, Git, dan DBeaver sudah terpasang di komputer Anda.
