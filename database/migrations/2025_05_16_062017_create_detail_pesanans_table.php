<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('id_detail_pesanan'); // Primary key dan auto-increment
            $table->unsignedBigInteger('id_pesanan'); // Foreign key ke tabel pesanans
            $table->unsignedBigInteger('id_produk'); // Foreign key ke tabel produk
            $table->integer('jumlah'); // Jumlah produk
            $table->decimal('total_bayar', 10, 2); // Total bayar untuk produk ini
            $table->enum('status', ['Diproses', 'Dikirim', 'Selesai'])->default('Diproses');
            $table->timestamps();

            
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanans')->onDelete('cascade');

            
            $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
