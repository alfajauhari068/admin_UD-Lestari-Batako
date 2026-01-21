<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model ProduksiKaryawanTim
 * 
 * Tabel ini BUKAN tempat menyimpan gaji final, tapi LOG keikutsertaan anggota tim
 * 
 * PENTING:
 * - upah_per_unit DIABAIKAN / TIDAK DIGUNAKAN DALAM PERHITUNGAN
 * - Gaji dihitung dari SERVICE (GajiTimService) berdasarkan TIM, bukan individual
 * - Tabel ini hanya track: siapa, kontribusi unit, tanggal
 */
class ProduksiKaryawanTim extends Model
{
    protected $table = 'produksi_karyawan_tim'; // Nama tabel di database
    protected $fillable = [
        'id_produksi',
        'id_karyawan',
        'jumlah_unit',
        'tanggal_produksi',
        // PERHATIAN: upah_per_unit tidak lagi di-fillable karena akan diabaikan
    ];

    protected $casts = [
        'jumlah_unit' => 'integer',
        'tanggal_produksi' => 'date',
    ];

    /**
     * Relasi ke model Produksi (produksis.id_produksi)
     */
    public function produksi(): BelongsTo
    {
        return $this->belongsTo(Produksi::class, 'id_produksi', 'id_produksi');
    }

    /**
     * Relasi ke model Karyawan (karyawans.id_karyawan)
     */
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
