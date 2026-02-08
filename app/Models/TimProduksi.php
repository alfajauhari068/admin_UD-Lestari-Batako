<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model TimProduksi
 * 
 * Tabel UNIFIED untuk tracking:
 * - Keanggotaan tim produksi (relasi M:N antara Produksi dan Karyawan)
 * - Kontribusi per-karyawan (jumlah_produksi)
 * - Tanggal produksi
 * 
 * Use cases:
 * 1. Query anggota tim untuk produksi tertentu
 * 2. Query produksi yang dikerjakan karyawan
 * 3. Aggregate kontribusi untuk perhitungan gaji
 * 4. Track partisipasi tim per tanggal
 */
class TimProduksi extends Model
{
  protected $table = 'tim_produksi';
  protected $primaryKey = 'id';
  protected $keyType = 'int';
  public $incrementing = true;
  public $timestamps = true;

  protected $fillable = [
    'id_produksi',
    'id_karyawan',
    'jumlah_produksi',
    'tanggal_produksi',
  ];

  protected $casts = [
    'id_produksi' => 'integer',
    'id_karyawan' => 'integer',
    'jumlah_produksi' => 'integer',
    'tanggal_produksi' => 'date',
  ];

  /**
   * Relasi ke Produksi (M:1)
   * Banyak tim_produksi dapat belong to satu produksi
   */
  public function produksi(): BelongsTo
  {
    return $this->belongsTo(Produksi::class, 'id_produksi', 'id_produksi');
  }

  /**
   * Relasi ke Karyawan (M:1)
   * Banyak tim_produksi dapat belong to satu karyawan
   */
  public function karyawan(): BelongsTo
  {
    return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
  }

  /**
   * Scope untuk query tim produksi pada tanggal tertentu
   */
  public function scopeByTanggal($query, $tanggal)
  {
    return $query->whereDate('tanggal_produksi', $tanggal);
  }

  /**
   * Scope untuk query tim produksi untuk produksi tertentu
   */
  public function scopeForProduksi($query, $id_produksi)
  {
    return $query->where('id_produksi', $id_produksi);
  }

  /**
   * Scope untuk query tim produksi untuk karyawan tertentu
   */
  public function scopeForKaryawan($query, $id_karyawan)
  {
    return $query->where('id_karyawan', $id_karyawan);
  }

  /**
   * Scope untuk aggregate kontribusi
   */
  public function scopeTotalKontribusi($query)
  {
    return $query->sum('jumlah_produksi');
  }

  // ============================================================
  // REPORTING METHODS - READ-ONLY CALCULATIONS
  // Tidak menyimpan hasil, hanya melakukan query aggregation
  // ============================================================

  /**
   * Total produksi per hari (across all employees)
   * GROUP BY tanggal_produksi
   * 
   * @return \Illuminate\Support\Collection
   */
  public static function totalPerHari()
  {
    return self::selectRaw('tanggal_produksi, SUM(jumlah_produksi) as total_produksi, COUNT(DISTINCT id_karyawan) as jumlah_karyawan')
      ->groupBy('tanggal_produksi')
      ->orderBy('tanggal_produksi', 'desc')
      ->get();
  }

  /**
   * Total produksi per hari untuk produksi tertentu
   * GROUP BY tanggal_produksi, id_produksi
   * 
   * @param int $id_produksi
   * @return \Illuminate\Support\Collection
   */
  public static function totalPerHariByProduksi($id_produksi)
  {
    return self::selectRaw('tanggal_produksi, id_produksi, SUM(jumlah_produksi) as total_produksi, COUNT(id_karyawan) as jumlah_karyawan')
      ->where('id_produksi', $id_produksi)
      ->groupBy('tanggal_produksi', 'id_produksi')
      ->orderBy('tanggal_produksi', 'desc')
      ->get();
  }

  /**
   * Total produksi per karyawan (all time)
   * GROUP BY id_karyawan
   * 
   * @return \Illuminate\Support\Collection
   */
  public static function totalPerKaryawan()
  {
    return self::selectRaw('id_karyawan, SUM(jumlah_produksi) as total_produksi, COUNT(DISTINCT tanggal_produksi) as hari_bekerja')
      ->groupBy('id_karyawan')
      ->orderBy('total_produksi', 'desc')
      ->get();
  }

  /**
   * Total produksi per karyawan per hari
   * GROUP BY id_karyawan, tanggal_produksi
   * 
   * @return \Illuminate\Support\Collection
   */
  public static function totalPerKaryawanPerHari()
  {
    return self::selectRaw('id_karyawan, tanggal_produksi, SUM(jumlah_produksi) as total_produksi, COUNT(id_produksi) as jumlah_produk')
      ->groupBy('id_karyawan', 'tanggal_produksi')
      ->orderBy('tanggal_produksi', 'desc')
      ->orderBy('id_karyawan')
      ->get();
  }

  /**
   * Total produksi per produksi (all time)
   * GROUP BY id_produksi
   * 
   * @return \Illuminate\Support\Collection
   */
  public static function totalPerProduksi()
  {
    return self::selectRaw('id_produksi, SUM(jumlah_produksi) as total_produksi, COUNT(DISTINCT id_karyawan) as jumlah_karyawan, COUNT(DISTINCT tanggal_produksi) as hari_produksi')
      ->groupBy('id_produksi')
      ->orderBy('total_produksi', 'desc')
      ->get();
  }

  /**
   * Breakdown detail per tanggal dengan karyawan detail
   * 
   * @param \DateTime|string $tanggal
   * @return \Illuminate\Support\Collection
   */
  public static function breakdownDetailHarian($tanggal)
  {
    return self::with(['karyawan:id_karyawan,nama_karyawan', 'produksi:id_produksi,nama_produk'])
      ->whereDate('tanggal_produksi', $tanggal)
      ->orderBy('id_produksi')
      ->orderBy('id_karyawan')
      ->get();
  }

  /**
   * Average produksi per karyawan per hari
   * 
   * @return \Illuminate\Support\Collection
   */
  public static function rataRataProduksiPerKaryawan()
  {
    return self::selectRaw('id_karyawan, AVG(jumlah_produksi) as rata_rata_produksi, MIN(jumlah_produksi) as min_produksi, MAX(jumlah_produksi) as max_produksi')
      ->groupBy('id_karyawan')
      ->orderBy('rata_rata_produksi', 'desc')
      ->get();
  }

  /**
   * Statistik produksi dalam range tanggal
   * 
   * @param \DateTime|string $dari_tanggal
   * @param \DateTime|string $sampai_tanggal
   * @return \Illuminate\Support\Collection
   */
  public static function statistikRange($dari_tanggal, $sampai_tanggal)
  {
    return self::selectRaw('
            tanggal_produksi,
            COUNT(DISTINCT id_karyawan) as jumlah_karyawan,
            COUNT(DISTINCT id_produksi) as jumlah_produk,
            SUM(jumlah_produksi) as total_produksi,
            AVG(jumlah_produksi) as rata_rata,
            MIN(jumlah_produksi) as min,
            MAX(jumlah_produksi) as max
        ')
      ->whereBetween('tanggal_produksi', [$dari_tanggal, $sampai_tanggal])
      ->groupBy('tanggal_produksi')
      ->orderBy('tanggal_produksi', 'desc')
      ->get();
  }
}
