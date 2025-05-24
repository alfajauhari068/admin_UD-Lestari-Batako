<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans'; // Nama tabel di database

    protected $primaryKey = 'id_pelanggan'; // Primary key

    protected $fillable = ['nama', 'email', 'no_hp', 'alamat']; // Kolom yang dapat diisi

    public function pesanan(): HasOne
    {
        return $this->hasOne('Appp\Models\Pesanan');
    }
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pelanggan) {
            $pelanggan->pesanans()->delete(); // Hapus semua pesanan terkait
        });
    }
}

