<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
