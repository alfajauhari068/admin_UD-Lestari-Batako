<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model TimProduksi
 * 
 * FINAL STRUCTURE (Transaksi Harian):
 * - id_produksi (FK ke produksis - master ongkos)
 * - id_produk (FK ke produk - for quick access)
 * - id_karyawan (FK ke karyawans)
 * - tanggal_produksi
 * - jumlah_produksi
 * - upah_per_unit (SNAPSHOT dari master ongkos - tidak berubah meski master diubah)
 * - total_upah (auto-calculated: jumlah × upah_per_unit)
 */
class TimProduksi extends Model
{
  protected $table = 'tim_produksi';
  protected $primaryKey = 'id';
  protected $keyType = 'int';
  public $incrementing = true;
  public $timestamps = true;

  /**
   * FINAL FILLABLE - Transaksi Harian:
   * WAJIB simpan snapshot upah_per_unit agar tidak terpengaruh perubahan master
   */
  protected $fillable = [
    'id_produksi',
    'id_produk',
    'id_karyawan',
    'jumlah_produksi',
    'tanggal_produksi',
    'upah_per_unit',    // SNAPSHOT - tidak berubah meski master diubah
    'total_upah',       // AUTO-CALCULATED
  ];

  protected $casts = [
    'id_produksi' => 'integer',
    'id_produk' => 'integer',
    'id_karyawan' => 'integer',
    'jumlah_produksi' => 'integer',
    'tanggal_produksi' => 'date',
    'upah_per_unit' => 'decimal:2',
    'total_upah' => 'decimal:2',
  ];

  /**
   * Relasi ke Produksi (Master Ongkos)
   */
  public function produksi(): BelongsTo
  {
    return $this->belongsTo(Produksi::class, 'id_produksi', 'id_produksi');
  }

  /**
   * Relasi ke Produk (for quick access)
   */
  public function produk(): BelongsTo
  {
    return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
  }

  /**
   * Relasi ke Karyawan
   */
  public function karyawan(): BelongsTo
  {
    return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
  }

  // ============================================================
  // AUTO-CALCULATE TOTAL_UPAH
  // Called when creating/updating records
  // ============================================================

  /**
   * Boot method to auto-calculate total_upah before saving
   */
  protected static function boot()
  {
    parent::boot();

    static::saving(function ($model) {
      // Auto-calculate total_upah from snapshot
      if ($model->jumlah_produksi && $model->upah_per_unit) {
        $model->total_upah = $model->jumlah_produksi * $model->upah_per_unit;
      } else {
        $model->total_upah = 0;
      }
    });
  }

  // ============================================================
  // SCOPES
  // ============================================================

  public function scopeByTanggal($query, $tanggal)
  {
    return $query->whereDate('tanggal_produksi', $tanggal);
  }

  public function scopeForProduksi($query, $id_produksi)
  {
    return $query->where('id_produksi', $id_produksi);
  }

  public function scopeForKaryawan($query, $id_karyawan)
  {
    return $query->where('id_karyawan', $id_karyawan);
  }

  public function scopeForProduk($query, $produk_id)
  {
    return $query->where('id_produk', $produk_id);
  }

  // ============================================================
  // ACCESSORS & HELPERS
  // ============================================================

  /**
   * Format total_upah untuk display
   */
  public function getTotalUpahFormattedAttribute(): string
  {
    return 'Rp ' . number_format($this->total_upah ?? 0, 0, ',', '.');
  }

  /**
   * Format upah_per_unit untuk display
   */
  public function getUpahPerUnitFormattedAttribute(): string
  {
    return 'Rp ' . number_format($this->upah_per_unit ?? 0, 0, ',', '.');
  }

  // ============================================================
  // STATIC AGGREGATE METHODS
  // ============================================================

  /**
   * Total produksi per hari
   */
  public static function totalPerHari()
  {
    return self::selectRaw('tanggal_produksi, SUM(jumlah_produksi) as total_produksi, COUNT(DISTINCT id_karyawan) as jumlah_karyawan')
      ->groupBy('tanggal_produksi')
      ->orderBy('tanggal_produksi', 'desc')
      ->get();
  }

  /**
   * Total upah per hari
   */
  public static function totalUpahPerHari()
  {
    return self::selectRaw('tanggal_produksi, SUM(total_upah) as total_upah')
      ->groupBy('tanggal_produksi')
      ->orderBy('tanggal_produksi', 'desc')
      ->get();
  }

  /**
   * Total produksi per karyawan
   */
  public static function totalPerKaryawan()
  {
    return self::selectRaw('id_karyawan, SUM(jumlah_produksi) as total_produksi, SUM(total_upah) as total_upah, COUNT(DISTINCT tanggal_produksi) as hari_bekerja')
      ->groupBy('id_karyawan')
      ->orderBy('total_upah', 'desc')
      ->get();
  }

  /**
   * Statistik range tanggal
   */
  public static function statistikRange($dari_tanggal, $sampai_tanggal)
  {
    return self::selectRaw('
        tanggal_produksi,
        COUNT(DISTINCT id_karyawan) as jumlah_karyawan,
        COUNT(DISTINCT id_produksi) as jumlah_produk,
        SUM(jumlah_produksi) as total_produksi,
        SUM(total_upah) as total_upah,
        AVG(jumlah_produksi) as rata_rata
      ')
      ->whereBetween('tanggal_produksi', [$dari_tanggal, $sampai_tanggal])
      ->groupBy('tanggal_produksi')
      ->orderBy('tanggal_produksi', 'desc')
      ->get();
  }
}
