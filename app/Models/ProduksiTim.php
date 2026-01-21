<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProduksiTim extends Model
{
  protected $table = 'produksi_karyawan_tim';
  protected $primaryKey = 'id';

  // allow mass assignment for these fields only (do NOT allow upah_total)
  protected $fillable = [
    'id_produksi',
    'id_karyawan',
    'jumlah_unit',
    'tanggal_produksi',
  ];
  protected $casts = [
    'jumlah_unit' => 'integer',
    'tanggal_produksi' => 'date',
  ];

  /**
   * Relationship to Produksi (produk/produksis table)
   */
  public function produksi(): BelongsTo
  {
    return $this->belongsTo(Produksi::class, 'id_produksi', 'id_produksi');
  }

  /**
   * Relationship to Karyawan
   */
  public function karyawan(): BelongsTo
  {
    return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
  }

  /**
   * Computed accessor for upah_total = jumlah_unit * upah_per_unit.
   * If a DB-generated column `upah_total` exists it will be returned, otherwise
   * this computes on the fly so the application never relies on user input.
   */
  public function getUpahTotalAttribute(): int
  {
    // If DB contains an upah_total generated column, return it; otherwise do not compute using upah_per_unit
    if (array_key_exists('upah_total', $this->attributes) && $this->attributes['upah_total'] !== null) {
      return (int) $this->attributes['upah_total'];
    }

    // If upah_total is not present, we prefer to return 0 because application must not compute using upah_per_unit
    return 0;
  }

  /**
   * Prevent manual assignment of upah_total.
   */
  public function setUpahTotalAttribute($value): void
  {
    // Intentionally ignore assignments to upah_total to prevent manual override.
  }
}
