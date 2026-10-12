<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level_pedas', function (Blueprint $table) {
            $table->id('id_level');
            $table->string('nama_level');
            $table->decimal('tambahan_harga', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('level_pedas');
    }
};