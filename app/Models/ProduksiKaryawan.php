<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\produksi_karyawan_tim;

class ProduksiKaryawan extends Model
{
    use HasFactory;

    protected $table = 'produksi_karyawans';
    protected $fillable = [
        'id_karyawan',
        'id_produksi',
        'tanggal_produksi',
        'jumlah_unit',
        'upah_total',
    ];

    // Relasi ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    // Relasi ke Produksi
    public function produksi()
    {
        return $this->belongsTo(Produksi::class, 'id_produksi');
    }
    public function tim()
    {
        return $this->hasMany(produksi_karyawan_tim::class, 'id_produksi_karyawan');
    }
}
