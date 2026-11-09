<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            // Profil Usaha
            $table->string('nama_kedai')->default('Seblak Nashwa');
            $table->string('tagline')->nullable();
            $table->string('nomor_whatsapp')->nullable();
            $table->string('email_kedai')->nullable();
            $table->text('alamat_kedai')->nullable();

            // Status Operasional
            $table->boolean('kedai_buka')->default(true);
            $table->boolean('jeda_pesanan')->default(false);

            // Layanan Pesanan
            $table->decimal('biaya_layanan', 10, 2)->default(2000);
            $table->decimal('ongkir_tetap', 10, 2)->default(8000);

            // Metode Pembayaran
            $table->boolean('qris_aktif')->default(true);
            $table->boolean('transfer_aktif')->default(true);
            $table->boolean('cod_aktif')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};