<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimen';
    protected $primaryKey = 'id_pengiriman';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pesanan',
        'id_pelanggan',
        'alamat_pengiriman',
        'latitude',
        'longitude',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'tanggal_pengiriman',
        'jenis_pengiriman',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pengiriman' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Relasi ke Pesanan
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Relasi ke Pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Accessor untuk format status badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Menunggu Dijadwalkan' => 'warning',
            'Dalam Pengiriman' => 'info',
            'Terkirim' => 'success',
            'Dibatalkan' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
