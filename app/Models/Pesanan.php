<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pelanggan',
        'tanggal_pesanan',
        'catatan',
        'status',
        'total_harga',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'date',
        'total_harga' => 'decimal:2',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Calculate total price from order details
     */
    public function calculateTotal()
    {
        return $this->detailPesanan->sum(function ($detail) {
            return $detail->jumlah * $detail->produk->harga_satuan;
        });
    }

    /**
     * Update total_harga based on order details
     */
    public function updateTotal()
    {
        $this->total_harga = $this->calculateTotal();
        $this->save();
    }

    /**
     * Check if order can be modified (not completed or cancelled)
     */
    public function canBeModified()
    {
        return !in_array($this->status, ['selesai', 'dibatalkan']);
    }

    /**
     * Reduce stock for all order items
     * Call this when order is confirmed
     */
    public function reduceStock()
    {
        DB::transaction(function () {
            foreach ($this->detailPesanan as $detail) {
                $detail->produk->reduceStock($detail->jumlah);
            }
        });
    }

    /**
     * Restore stock for all order items
     * Call this when order is cancelled
     */
    public function restoreStock()
    {
        DB::transaction(function () {
            foreach ($this->detailPesanan as $detail) {
                $detail->produk->increaseStock($detail->jumlah);
            }
        });
    }

    /**
     * Get total quantity of all items in order
     */
    public function getTotalQuantity()
    {
        return $this->detailPesanan->sum('jumlah');
    }
}
