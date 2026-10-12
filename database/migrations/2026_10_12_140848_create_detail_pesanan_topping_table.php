<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanan_topping', function (Blueprint $table) {
            $table->foreignId('id_detail')->constrained('detail_pesanan', 'id_detail')->cascadeOnDelete();
            $table->foreignId('id_topping')->constrained('topping', 'id_topping');
            $table->decimal('harga', 10, 2);
            $table->primary(['id_detail', 'id_topping']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan_topping');
    }
};