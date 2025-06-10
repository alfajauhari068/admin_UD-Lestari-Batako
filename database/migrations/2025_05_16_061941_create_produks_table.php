<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk'); // Secara default, ini adalah unsignedBigInteger
            $table->string('nama_produk', 100);
            $table->string('gambar_produk')->nullable();
            $table->decimal('harga_satuan', 10, 2);
            $table->text('deskripsi_produk')->nullable();
            $table->integer('stok_tersedia');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
