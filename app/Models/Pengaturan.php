<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';

    protected $fillable = [
        'nama_kedai',
        'tagline',
        'nomor_whatsapp',
        'email_kedai',
        'alamat_kedai',
        'kedai_buka',
        'jeda_pesanan',
        'biaya_layanan',
        'ongkir_tetap',
        'qris_aktif',
        'transfer_aktif',
        'cod_aktif',
    ];
}