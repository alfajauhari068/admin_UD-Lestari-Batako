<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produksi_karyawan_tim', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('id_produksi_karyawan'); // FK ke produksi_karyawans
            $table->unsignedBigInteger('id_karyawan'); // FK ke karyawans
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_produksi_karyawan')->references('id')->on('produksi_karyawans')->onDelete('cascade');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi_karyawan_tim');
    }
};
