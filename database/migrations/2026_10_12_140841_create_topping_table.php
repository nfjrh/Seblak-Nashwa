<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topping', function (Blueprint $table) {
            $table->id('id_topping');
            $table->string('nama_topping');
            $table->decimal('harga', 10, 2);
            $table->unsignedInteger('stok')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topping');
    }
};