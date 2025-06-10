<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pelanggan';
    protected $table = 'pelanggans';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
    ];

    public function Pesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function Pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'id_pelanggan', 'id_pelanggan');
    }
}
