<?php

namespace Database\Seeders;

use App\Models\LevelPedas;
use App\Models\Menu;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PesananContohSeeder extends Seeder
{
    public function run(): void
    {
        if (Pesanan::where('catatan', 'Data contoh')->exists()) {
            $this->command?->info('Data contoh pesanan sudah ada, dilewati.');
            return;
        }

        $pembeli = User::where('email', 'pembeli@seblak.test')->first();
        $menu = Menu::first();
        $level = LevelPedas::first();

        if (! $pembeli || ! $menu || ! $level) {
            $this->command?->warn('Jalankan DatabaseSeeder dan KedaiSeeder dulu.');
            return;
        }

        $contoh = [
            [Pesanan::STATUS_BARU,     Pesanan::AMBIL, Pembayaran::STATUS_MENUNGGU, 'tunai'],
            [Pesanan::STATUS_DIPROSES, Pesanan::ANTAR, Pembayaran::STATUS_LUNAS,    'transfer'],
            [Pesanan::STATUS_SIAP,     Pesanan::AMBIL, Pembayaran::STATUS_LUNAS,    'qris'],
            [Pesanan::STATUS_SELESAI,  Pesanan::ANTAR, Pembayaran::STATUS_LUNAS,    'transfer'],
            [Pesanan::STATUS_BATAL,    Pesanan::AMBIL, Pembayaran::STATUS_DITOLAK,  'transfer'],
        ];

        foreach ($contoh as $i => [$status, $metode, $statusBayar, $caraBayar]) {
            $jumlah = $i + 1;
            $harga = (float) $menu->harga;
            $subtotal = $harga * $jumlah;

            $pesanan = Pesanan::create([
                'id_user'            => $pembeli->id_user,
                'tanggal_pesanan'    => now()->subHours($i * 5),
                'total_harga'        => $subtotal,
                'metode_pengambilan' => $metode,
                'alamat'             => $metode === Pesanan::ANTAR ? 'Jl. Contoh No. 1' : null,
                'catatan'            => 'Data contoh',
                'status_pesanan'     => $status,
            ]);

            $pesanan->detailPesanans()->create([
                'id_menu'  => $menu->id_menu,
                'id_level' => $level->id_level,
                'jumlah'   => $jumlah,
                'harga'    => $harga,
                'subtotal' => $subtotal,
            ]);

            Pembayaran::create([
                'id_pesanan'         => $pesanan->id_pesanan,
                'metode_pembayaran'  => $caraBayar,
                'jumlah_pembayaran'  => $subtotal,
                'status_pembayaran'  => $statusBayar,
                'tanggal_pembayaran' => $statusBayar === Pembayaran::STATUS_LUNAS ? now() : null,
            ]);
        }
    }
}