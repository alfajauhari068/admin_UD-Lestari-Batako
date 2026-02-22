<?php

namespace App\Services;

use App\Models\ProduksiKaryawanTim;
use App\Models\Produksi;
use Exception;

/**
 * Service untuk menghitung upah/gaji tim produksi
 * 
 * LOGIKA BISNIS (WAJIB):
 * Gaji dihitung dari total produksi TIM, bukan individual
 * 
 * ALUR:
 * A. total_unit_tim = SUM(jumlah_unit dari semua anggota tim)
 * B. total_upah_tim = total_unit_tim * produksis.upah_per_unit
 * C. jumlah_anggota = COUNT(DISTINCT id_karyawan)
 * D. upah_per_karyawan = total_upah_tim / jumlah_anggota (jika perlu distribusi rata)
 */
class GajiTimService
{
  /**
   * Hitung upah per karyawan untuk satu produksi di tanggal tertentu
   * 
   * @param int $id_produksi
   * @param string|null $tanggal_produksi (YYYY-MM-DD, optional untuk filter by date)
   * @return array [
   *   'total_unit_tim' => int,
   *   'total_upah_tim' => int,
   *   'jumlah_anggota' => int,
   *   'upah_per_karyawan' => int,
   * ]
   * @throws Exception
   */
  public function hitungGajiTim(int $id_produksi, ?string $tanggal_produksi = null, ?Produksi $produksi = null): array
  {
    // Guard Clause: Cek validasi produksi (reuse provided model if available)
    if (!$produksi) {
      $produksi = Produksi::find($id_produksi);
      if (!$produksi) {
        throw new Exception("Produksi dengan ID {$id_produksi} tidak ditemukan");
      }
    }

    // Guard Clause: Cek validasi kolom penting
    if ($produksi->upah_per_unit === null) {
      throw new Exception("upah_per_unit tidak boleh kosong");
    }

    // Query data produksi karyawan tim
    $query = ProduksiKaryawanTim::where('id_produksi', $id_produksi);

    // Filter by tanggal jika diberikan
    if ($tanggal_produksi) {
      $query->whereDate('tanggal_produksi', $tanggal_produksi);
    }

    $records = $query->get();

    // Guard Clause: Cek ada data
    if ($records->isEmpty()) {
      return [
        'total_unit_tim' => 0,
        'total_upah_tim' => 0,
        'jumlah_anggota' => 0,
        'upah_per_karyawan' => 0,
      ];
    }

    // A. Hitung total unit tim
    $total_unit_tim = $records->sum('jumlah_unit');

    // C. Hitung jumlah anggota tim (distinct karyawan)
    $jumlah_anggota = $records->pluck('id_karyawan')->unique()->count();

    // Guard Clause: Cek jumlah anggota
    if ($jumlah_anggota < 1) {
      throw new Exception("Anggota tim tidak boleh kosong");
    }

    // B. Hitung total upah tim: total_unit_tim * upah_per_unit
    $total_upah_tim = $total_unit_tim * $produksi->upah_per_unit;

    // Hitung upah per karyawan (distribusi rata ke semua anggota)
    $upah_per_karyawan = $jumlah_anggota > 0 ? (int) round($total_upah_tim / $jumlah_anggota) : 0;

    return [
      'total_unit_tim' => $total_unit_tim,
      'total_upah_tim' => $total_upah_tim,
      'jumlah_anggota' => $jumlah_anggota,
      'upah_per_karyawan' => $upah_per_karyawan,
    ];
  }

  /**
   * Hitung upah per karyawan untuk satu tim berdasarkan record ProduksiKaryawanTim
   * (untuk detail view yang menampilkan semua anggota tim)
   * 
   * @param ProduksiKaryawanTim $record
   * @return array [
   *   'produksi' => Produksi model,
   *   'total_unit_tim' => int,
   *   'total_upah_tim' => int,
   *   'jumlah_anggota' => int,
   *   'upah_per_karyawan' => int,
   * ]
   * @throws Exception
   */
  public function hitungGajiUntukDetailTim(ProduksiKaryawanTim $record): array
  {
    $id_produksi = $record->id_produksi;
    $tanggal = $record->tanggal_produksi?->format('Y-m-d');

    // Load produksi once and pass to hitungGajiTim to avoid duplicate lookups
    $produksi = Produksi::find($id_produksi);
    $gajiData = $this->hitungGajiTim($id_produksi, $tanggal, $produksi);

    return array_merge($gajiData, [
      'produksi' => $produksi,
    ]);
  }
}
