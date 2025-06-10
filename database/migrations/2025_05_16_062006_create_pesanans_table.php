<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan'); // Primary key dan auto-increment
            $table->unsignedBigInteger('id_pelanggan'); // Foreign key ke tabel pelanggan
            $table->text('catatan')->nullable();
            $table->timestamps();

            
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
