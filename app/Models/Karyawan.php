<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans'; // Nama tabel di database
    protected $primaryKey = 'id_karyawan'; // Primary key tabel
    protected $fillable = ['nama', 'jabatan', 'no_hp', 'alamat']; // Kolom yang dapat diisi
}
