<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\TimProduksi;
use App\Models\Produk;
use App\Models\Karyawan;

class Produksi extends Model
{
    use HasFactory;

    protected $table = 'produksis';
    protected $primaryKey = 'id_produksi';

    /**
     * FINAL STRUCTURE - Master Ongkos:
     * - id_produk (FK to produk)
     * - upah_per_unit (wage per unit)
     * - satuan (unit of measurement)
     * - keterangan (notes)
     */
    protected $fillable = [
        'id_produk',
        'upah_per_unit',
        'satuan',
        'keterangan',
    ];

    protected $casts = [
        'id_produk' => 'integer',
        'upah_per_unit' => 'decimal:2',
    ];

    /**
     * Relasi ke TimProduksi (Transaksi Harian)
     * Satu master ongkos produksi dapat memiliki banyak transaksi
     */
    public function timProduksi(): HasMany
    {
        return $this->hasMany(TimProduksi::class, 'id_produksi', 'id_produksi');
    }

    /**
     * Relasi ke master Produk
     * Setiap ongkos produksi pasti связано с produk
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    /**
     * Relasi M:N ke Karyawan via TimProduksi
     * Semua karyawan yang pernah bekerja dengan produksi ini
     */
    public function karyawan(): BelongsToMany
    {
        return $this->belongsToMany(
            Karyawan::class,
            'tim_produksi',
            'id_produksi',
            'id_karyawan'
        )
            ->withPivot('jumlah_produksi', 'tanggal_produksi', 'upah_per_unit', 'total_upah')
            ->withTimestamps();
    }

    // ============================================================
    // ACCESSORS & FORMATTING
    // ============================================================

    /**
     * Format upah_per_unit untuk display
     */
    public function getUpahFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->upah_per_unit, 0, ',', '.');
    }

    /**
     * Display teks untuk dropdown
     */
    public function getDisplayTextAttribute(): string
    {
        $produkName = $this->produk ? $this->produk->nama_produk : 'Tanpa Produk';
        return "{$produkName} - {$this->upahFormatted} / {$this->satuan}";
    }
}
