<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ProduksiKaryawanTim;
use App\Models\TimProduksi;
use App\Models\Produk;
use App\Models\Karyawan;

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
     * Relasi ke TimProduksi (UNIFIED)
     * Satu produksi dapat memiliki banyak tim (per-tanggal, per-karyawan)
     */
    public function timProduksi(): HasMany
    {
        return $this->hasMany(TimProduksi::class, 'id_produksi', 'id_produksi');
    }

    /**
     * Relasi M:N ke Karyawan via TimProduksi
     * Query semua karyawan yang bekerja pada produksi ini
     */
    public function karyawan(): BelongsToMany
    {
        return $this->belongsToMany(
            Karyawan::class,
            'tim_produksi',
            'id_produksi',
            'id_karyawan'
        )
            ->using(TimProduksi::class)
            ->withPivot('jumlah_produksi', 'tanggal_produksi')
            ->withTimestamps();
    }

    /**
     * Relasi ke master Produk. Produksi sekarang mengacu ke Produk.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    // ============================================================
    // REPORTING METHODS - READ-ONLY CALCULATIONS
    // Convenience methods untuk mengakses agregasi tim_produksi
    // ============================================================

    /**
     * Total produksi untuk produksi ini (all time)
     * 
     * @return int
     */
    public function getTotalProduksi()
    {
        return $this->timProduksi()->sum('jumlah_produksi');
    }

    /**
     * Total produksi per hari untuk produksi ini
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getProduksiPerHari()
    {
        return $this->timProduksi()
            ->selectRaw('tanggal_produksi, SUM(jumlah_produksi) as total, COUNT(id_karyawan) as jumlah_karyawan')
            ->groupBy('tanggal_produksi')
            ->orderBy('tanggal_produksi', 'desc')
            ->get();
    }

    /**
     * Breakdown detail tim: per karyawan, total kontribusi
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getBreakdownTimPerKaryawan()
    {
        return $this->timProduksi()
            ->selectRaw('id_karyawan, SUM(jumlah_produksi) as total_produksi, COUNT(tanggal_produksi) as hari_bekerja, AVG(jumlah_produksi) as rata_rata')
            ->groupBy('id_karyawan')
            ->orderBy('total_produksi', 'desc')
            ->with('karyawan:id_karyawan,nama_karyawan')
            ->get();
    }

    /**
     * Statistik lengkap tim untuk produksi ini
     * 
     * @return array
     */
    public function getStatistikTimProduksi()
    {
        $tim = $this->timProduksi()->get();

        return [
            'total_produksi' => $tim->sum('jumlah_produksi'),
            'jumlah_karyawan' => $tim->groupBy('id_karyawan')->count(),
            'hari_produksi' => $tim->groupBy('tanggal_produksi')->count(),
            'rata_rata_per_hari' => $tim->groupBy('tanggal_produksi')->map(fn($g) => $g->sum('jumlah_produksi'))->avg(),
        ];
    }

    /**
     * Top performers untuk produksi ini (top 5 karyawan by kontribusi)
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getTopKaryawan($limit = 5)
    {
        return $this->timProduksi()
            ->selectRaw('id_karyawan, SUM(jumlah_produksi) as total_produksi, COUNT(tanggal_produksi) as hari_bekerja')
            ->groupBy('id_karyawan')
            ->orderBy('total_produksi', 'desc')
            ->limit($limit)
            ->with('karyawan:id_karyawan,nama_karyawan')
            ->get();
    }
}
