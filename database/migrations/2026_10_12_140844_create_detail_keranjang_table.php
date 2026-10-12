<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_keranjang', function (Blueprint $table) {
            $table->id('id_detail_keranjang');
            $table->foreignId('id_keranjang')->constrained('keranjang', 'id_keranjang')->cascadeOnDelete();
            $table->foreignId('id_menu')->constrained('menu', 'id_menu');
            $table->foreignId('id_level')->constrained('level_pedas', 'id_level');
            $table->unsignedInteger('jumlah')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_keranjang');
    }
};