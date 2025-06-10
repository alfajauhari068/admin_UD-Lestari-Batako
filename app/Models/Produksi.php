<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;

    protected $table = 'produksis'; // Nama tabel di database
    protected $primaryKey = 'id_produksi'; // Primary key tabel
    protected $fillable = ['nama_produksi', 'kriteria_gaji', 'gaji_per_unit']; // Kolom yang dapat diisi
}
