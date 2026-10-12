<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->dateTime('tanggal_pesanan')->useCurrent();
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->string('metode_pengambilan');
            $table->text('alamat')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status_pesanan')->default('baru');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};