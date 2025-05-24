<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama_produk', 'harga_satuan', 'stok_tersedia'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
