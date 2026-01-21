<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('produksi_karyawans')) {
            Schema::create('produksi_karyawans', function (Blueprint $table) {
                $table->id(); // Primary Key
                $table->unsignedBigInteger('id_produksi'); // FK ke produksis
                $table->date('tanggal_produksi'); // Tanggal produksi
                $table->integer('jumlah_unit'); // Contoh: 400
                $table->bigInteger('upah_total'); // Otomatis dihitung
                $table->timestamps();

                // Tambahkan foreign key secara eksplisit
                $table->foreign('id_produksi')->references('id_produksi')->on('produksis')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_karyawans');
    }
};

