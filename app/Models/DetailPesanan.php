<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanans';
    protected $primaryKey = 'id_detail_pesanan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'jumlah',
        'total_bayar',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'total_bayar' => 'decimal:2',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    /**
     * Calculate total price for this detail item
     */
    public function calculateTotal()
    {
        return $this->jumlah * $this->produk->harga_satuan;
    }

    /**
     * Update total_bayar based on current quantity and product price
     */
    public function updateTotal()
    {
        $this->total_bayar = $this->calculateTotal();
        $this->save();
    }

    /**
     * Get the unit price at the time of order
     */
    public function getUnitPrice()
    {
        return $this->produk->harga_satuan;
    }
}
