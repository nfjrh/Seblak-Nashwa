<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Level pedas boleh kosong (minuman dan topping tidak punya level pedas),
     * dan tiap item keranjang boleh punya catatan untuk dapur.
     */
    public function up(): void
    {
        Schema::table('detail_keranjang', function (Blueprint $table) {
            $table->dropForeign(['id_level']);
        });

        Schema::table('detail_keranjang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_level')->nullable()->change();
            $table->foreign('id_level')->references('id_level')->on('level_pedas');
            $table->string('catatan', 200)->nullable()->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('detail_keranjang', function (Blueprint $table) {
            $table->dropColumn('catatan');
            $table->dropForeign(['id_level']);
        });

        // Item tanpa level diberi level terendah supaya kolom bisa diwajibkan lagi
        DB::table('detail_keranjang')
            ->whereNull('id_level')
            ->update(['id_level' => DB::table('level_pedas')->min('id_level')]);

        Schema::table('detail_keranjang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_level')->nullable(false)->change();
            $table->foreign('id_level')->references('id_level')->on('level_pedas');
        });
    }
};
