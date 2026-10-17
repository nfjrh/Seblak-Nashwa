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
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->dateTime('tanggal_dibuat')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};