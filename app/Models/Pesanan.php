<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'tanggal_pesanan',
        'total_harga',
        'biaya_layanan',
        'ongkir',
        'metode_pengambilan',
        'nama_penerima',
        'nomor_penerima',
        'alamat',
        'detail_alamat',
        'catatan',
        'status_pesanan',
    ];

    // Tanggal pesanan dibaca sebagai objek tanggal (bisa di-format di view)
    protected $casts = [
        'tanggal_pesanan' => 'datetime',
    ];

    // Konstanta Status Pesanan
    const STATUS_BARU = 'baru';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SIAP = 'siap';
    const STATUS_SELESAI = 'selesai';
    const STATUS_BATAL = 'batal';

    // Konstanta Metode Pengambilan
    const AMBIL = 'ambil';
    const ANTAR = 'antar';

    // Konstanta biaya (rupiah). Pesanan ambil sendiri tidak dikenai biaya apa pun.
    const BIAYA_LAYANAN = 2000;
    const ONGKIR_TETAP = 8000;

    // Konstanta perkiraan waktu pesanan siap (menit sejak pesanan dibuat)
    const ESTIMASI_MIN = 30;
    const ESTIMASI_MAKS = 45;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    // Static method: biaya yang berlaku untuk satu cara pengambilan
    // Pemakaian: Pesanan::hitungBiaya(Pesanan::ANTAR)  ->  ['layanan' => 2000, 'ongkir' => 8000]
    public static function hitungBiaya(string $metodePengambilan): array
    {
        if ($metodePengambilan === self::ANTAR) {
            return ['layanan' => self::BIAYA_LAYANAN, 'ongkir' => self::ONGKIR_TETAP];
        }

        return ['layanan' => 0, 'ongkir' => 0];
    }

    public function scopeMilikUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    public function scopeStatusAktif($query)
    {
        return $query->whereIn('status_pesanan', [self::STATUS_BARU, self::STATUS_DIPROSES, self::STATUS_SIAP]);
    }

    public function getTotalRupiahAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getLabelStatusAttribute()
    {
        return match($this->status_pesanan) {
            self::STATUS_BARU => 'Baru',
            self::STATUS_DIPROSES => 'Diproses',
            self::STATUS_SIAP => 'Siap Diambil/Diantar',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_BATAL => 'Dibatalkan',
            default => ucfirst($this->status_pesanan),
        };
    }

    // Accessor: $pesanan->nomor_pesanan  ->  NSW-0012
    public function getNomorPesananAttribute()
    {
        return 'NSW-' . str_pad($this->id_pesanan, 4, '0', STR_PAD_LEFT);
    }

    // Accessor: $pesanan->subtotal_menu  ->  total dikurangi biaya layanan dan ongkir
    public function getSubtotalMenuAttribute()
    {
        return (float) $this->total_harga - (float) $this->biaya_layanan - (float) $this->ongkir;
    }

    // Accessor: $pesanan->estimasi_tiba  ->  "13.35–13.45"
    public function getEstimasiTibaAttribute()
    {
        $mulai = Carbon::parse($this->tanggal_pesanan);

        return $mulai->copy()->addMinutes(self::ESTIMASI_MIN)->format('H.i')
            . '–' . $mulai->copy()->addMinutes(self::ESTIMASI_MAKS)->format('H.i');
    }

    // Mutator: catatan dirapikan, dan catatan kosong disimpan sebagai null
    public function setCatatanAttribute($value)
    {
        $this->attributes['catatan'] = ($value === null || trim($value) === '') ? null : trim($value);
    }
}