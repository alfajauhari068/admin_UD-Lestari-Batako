<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ProduksiKaryawanTim;
use App\Models\Produk;

class Produksi extends Model
{
    use HasFactory;

    protected $table = 'produksis'; // Nama tabel di database
    protected $primaryKey = 'id_produksi'; // Primary key tabel
    protected $fillable = ['id_produk', 'jumlah_per_unit', 'kriteria_gaji', 'gaji_per_unit']; // Kolom yang dapat diisi

    protected $casts = [
        'id_produk' => 'integer',
        'jumlah_per_unit' => 'integer',
        'gaji_per_unit' => 'integer',
    ];

    /**
     * Relasi ke ProduksiKaryawanTim
     * Satu produksi dapat memiliki banyak anggota tim
     */
    public function produksiKaryawanTim(): HasMany
    {
        return $this->hasMany(ProduksiKaryawanTim::class, 'id_produksi', 'id_produksi');
    }

    /**
     * Relasi ke master Produk. Produksi sekarang mengacu ke Produk.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
