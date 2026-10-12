<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_pesanan')->unique()->constrained('pesanan', 'id_pesanan')->cascadeOnDelete();
            $table->foreignId('id_verifikator')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('metode_pembayaran');
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->decimal('jumlah_pembayaran', 10, 2);
            $table->string('status_pembayaran')->default('menunggu');
            $table->string('bukti_pembayaran')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};