<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks'; // Nama tabel di database

    protected $primaryKey = 'id_produk'; // Primary key

    protected $fillable = [
        'nama_produk',
        'gambar_produk',
        'harga_satuan',
        'stok_tersedia',
        'deskripsi_produk', // Tambahkan kolom ini
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk', 'id_produk');
    }

    /**
     * Reduce product stock safely.
     *
     * Uses a DB transaction and row lock to avoid race conditions.
     * Throws Exception if stock is insufficient or product not found.
     *
     * @param int $jumlah
     * @return $this
     * @throws \Exception
     */
    public function reduceStock(int $jumlah)
    {
        if ($jumlah <= 0) {
            return $this;
        }

        return DB::transaction(function () use ($jumlah) {
            // Lock the row for update to avoid concurrent modifications
            $produk = self::where('id_produk', $this->id_produk)->lockForUpdate()->first();

            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan');
            }

            if ($produk->stok_tersedia < $jumlah) {
                throw new \Exception('Stok tidak mencukupi untuk produk: ' . $produk->nama_produk);
            }

            $produk->stok_tersedia = $produk->stok_tersedia - $jumlah;
            $produk->save();

            return $produk;
        });
    }
}
