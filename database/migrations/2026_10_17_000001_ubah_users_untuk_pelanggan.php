<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
| Di desain halaman daftar, email bersifat opsional dan pelanggan masuk memakai
| nomor WhatsApp. Jadi: email boleh kosong, dan nomor_hp harus unik.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });

        if (! Schema::hasIndex('users', 'users_nomor_hp_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('nomor_hp');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasIndex('users', 'users_nomor_hp_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_nomor_hp_unique');
            });
        }
    }
};
