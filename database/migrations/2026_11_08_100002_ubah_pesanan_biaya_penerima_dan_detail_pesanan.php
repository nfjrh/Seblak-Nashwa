<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * pesanan: biaya layanan, ongkir, dan data penerima.
     * detail_pesanan: level pedas boleh kosong, dan catatan per item.
     */
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->decimal('biaya_layanan', 10, 2)->default(0)->after('total_harga');
            $table->decimal('ongkir', 10, 2)->default(0)->after('biaya_layanan');
            $table->string('nama_penerima', 100)->nullable()->after('metode_pengambilan');
            $table->string('nomor_penerima', 20)->nullable()->after('nama_penerima');
            $table->string('detail_alamat', 200)->nullable()->after('alamat');
        });

        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->dropForeign(['id_level']);
        });

        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_level')->nullable()->change();
            $table->foreign('id_level')->references('id_level')->on('level_pedas');
            $table->string('catatan', 200)->nullable()->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->dropColumn('catatan');
            $table->dropForeign(['id_level']);
        });

        DB::table('detail_pesanan')
            ->whereNull('id_level')
            ->update(['id_level' => DB::table('level_pedas')->min('id_level')]);

        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_level')->nullable(false)->change();
            $table->foreign('id_level')->references('id_level')->on('level_pedas');
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['biaya_layanan', 'ongkir', 'nama_penerima', 'nomor_penerima', 'detail_alamat']);
        });
    }
};
