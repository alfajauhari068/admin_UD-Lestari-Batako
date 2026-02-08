<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans'; // Nama tabel di database
    protected $primaryKey = 'id_karyawan'; // Primary key tabel
    protected $fillable = ['nama', 'jabatan', 'no_hp', 'alamat']; // Kolom yang dapat diisi

    /**
     * Relasi ke TimProduksi (UNIFIED)
     * Satu karyawan dapat bekerja di banyak produksi
     */
    public function timProduksi(): HasMany
    {
        return $this->hasMany(TimProduksi::class, 'id_karyawan', 'id_karyawan');
    }

    /**
     * Relasi M:N ke Produksi via TimProduksi
     * Query semua produksi yang dikerjakan karyawan ini
     */
    public function produksi(): BelongsToMany
    {
        return $this->belongsToMany(
            Produksi::class,
            'tim_produksi',
            'id_karyawan',
            'id_produksi'
        )
            ->using(TimProduksi::class)
            ->withPivot('jumlah_produksi', 'tanggal_produksi')
            ->withTimestamps();
    }

    // ============================================================
    // REPORTING METHODS - READ-ONLY CALCULATIONS
    // Convenience methods untuk mengakses agregasi tim_produksi
    // ============================================================

    /**
     * Total kontribusi produksi untuk karyawan ini (all time)
     * 
     * @return int
     */
    public function getTotalKontribusi()
    {
        return $this->timProduksi()->sum('jumlah_produksi');
    }

    /**
     * Kontribusi per hari untuk karyawan ini
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getKontribusiPerHari()
    {
        return $this->timProduksi()
            ->selectRaw('tanggal_produksi, SUM(jumlah_produksi) as total, COUNT(id_produksi) as jumlah_produk')
            ->groupBy('tanggal_produksi')
            ->orderBy('tanggal_produksi', 'desc')
            ->get();
    }

    /**
     * Breakdown detail per produksi: masing-masing produk yang dikerjakan
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getBreakdownPerProduksi()
    {
        return $this->timProduksi()
            ->selectRaw('id_produksi, SUM(jumlah_produksi) as total_kontribusi, COUNT(tanggal_produksi) as hari_bekerja, AVG(jumlah_produksi) as rata_rata')
            ->groupBy('id_produksi')
            ->orderBy('total_kontribusi', 'desc')
            ->with('produksi:id_produksi,id_produk')
            ->get();
    }

    /**
     * Statistik lengkap kontribusi karyawan ini
     * 
     * @return array
     */
    public function getStatistikKontribusi()
    {
        $tim = $this->timProduksi()->get();

        return [
            'total_kontribusi' => $tim->sum('jumlah_produksi'),
            'jumlah_produk' => $tim->groupBy('id_produksi')->count(),
            'hari_bekerja' => $tim->groupBy('tanggal_produksi')->count(),
            'rata_rata_per_hari' => $tim->groupBy('tanggal_produksi')->map(fn($g) => $g->sum('jumlah_produksi'))->avg(),
            'rata_rata_per_produk' => $tim->groupBy('id_produksi')->map(fn($g) => $g->sum('jumlah_produksi'))->avg(),
            'kontribusi_min' => $tim->min('jumlah_produksi'),
            'kontribusi_max' => $tim->max('jumlah_produksi'),
        ];
    }

    /**
     * Daftar produk yang dikerjakan dengan ranking
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getProdukYangDikerjakan()
    {
        return $this->timProduksi()
            ->selectRaw('id_produksi, SUM(jumlah_produksi) as total_kontribusi, COUNT(tanggal_produksi) as frekuensi')
            ->groupBy('id_produksi')
            ->orderBy('total_kontribusi', 'desc')
            ->with('produksi:id_produksi,id_produk')
            ->get();
    }

    /**
     * Performa harian detail
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getPerformaHarianDetail()
    {
        return $this->timProduksi()
            ->with('produksi:id_produksi,id_produk')
            ->orderBy('tanggal_produksi', 'desc')
            ->orderBy('id_produksi')
            ->get();
    }

    /**
     * Jumlah hari kerja total
     * 
     * @return int
     */
    public function getJumlahHariKerja()
    {
        return $this->timProduksi()
            ->distinct('tanggal_produksi')
            ->count('tanggal_produksi');
    }

    /**
     * Performa bulan tertentu
     * 
     * @param string $bulan Format: 'Y-m' e.g., '2026-01'
     * @return array
     */
    public function getPerformaBulan($bulan)
    {
        $tim = $this->timProduksi()
            ->whereRaw("DATE_FORMAT(tanggal_produksi, '%Y-%m') = ?", [$bulan])
            ->get();

        return [
            'bulan' => $bulan,
            'total_kontribusi' => $tim->sum('jumlah_produksi'),
            'hari_kerja' => $tim->groupBy('tanggal_produksi')->count(),
            'rata_rata_per_hari' => $tim->groupBy('tanggal_produksi')->map(fn($g) => $g->sum('jumlah_produksi'))->avg(),
            'jumlah_produk' => $tim->groupBy('id_produksi')->count(),
        ];
    }
}
