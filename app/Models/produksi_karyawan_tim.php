<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produksi_karyawan_tim extends Model
{
    use HasFactory;

    protected $table = 'produksi_karyawan_tim';
    protected $fillable = [
        'id_produksi_karyawan',
        'id_karyawan',
    ];

    public function produksiKaryawan()
    {
        return $this->belongsTo(ProduksiKaryawan::class, 'id_produksi_karyawan');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
    
    public function tim()
    {
        return $this->hasMany(ProduksiKaryawanTim::class, 'id_produksi_karyawan');
    }
}
