<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_keranjang_topping', function (Blueprint $table) {
            $table->foreignId('id_detail_keranjang')->constrained('detail_keranjang', 'id_detail_keranjang')->cascadeOnDelete();
            $table->foreignId('id_topping')->constrained('topping', 'id_topping');
            $table->primary(['id_detail_keranjang', 'id_topping']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_keranjang_topping');
    }
};