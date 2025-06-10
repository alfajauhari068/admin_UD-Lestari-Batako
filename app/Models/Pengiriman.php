<?php
// Model Pengiriman tanpa relasi kurir
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimen'; // Nama tabel di database
    protected $primaryKey = 'id_pengiriman'; // Primary key
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pesanan',
        'id_pelanggan',
        'alamat_pengiriman',
        'tanggal_pengiriman',
        'jasa_kurir',
        'no_resi',
    ];

    // Cast properti tanggal_pengiriman ke tipe date
    protected $casts = [
        'tanggal_pengiriman' => 'date',
    ];

    
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}

