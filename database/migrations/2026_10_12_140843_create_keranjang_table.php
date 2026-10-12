<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->dateTime('tanggal_dibuat')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};