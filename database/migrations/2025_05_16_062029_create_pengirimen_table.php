<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('pengirimen', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->unsignedBigInteger('id_pesanan');
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanans')->onDelete('cascade');
            $table->unsignedBigInteger('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
            $table->text('alamat_pengiriman');
            $table->date('tanggal_pengiriman')->nullable();
            $table->string('jasa_kurir', 100)->nullable();
            $table->string('no_resi', 100)->nullable();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('pengirimen');
    }
};
