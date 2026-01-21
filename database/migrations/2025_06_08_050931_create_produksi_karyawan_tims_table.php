<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('produksi_karyawan_tim')) {
            Schema::create('produksi_karyawan_tim', function (Blueprint $table) {
                $table->id(); // Primary Key
                $table->unsignedBigInteger('id_produksi'); // FK ke produksi
                $table->unsignedBigInteger('id_karyawan'); // FK ke karyawans
                $table->bigInteger('upah_per_unit')->default(0); // upah per unit untuk per-karyawan
                $table->integer('jumlah_unit'); // Jumlah unit yang diproduksi
                $table->date('tanggal_produksi'); // Tanggal produksi
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('id_produksi')->references('id_produksi')->on('produksis')->onDelete('cascade');
                $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawans')->onDelete('cascade');
            });

            // Create a stored generated column `upah_total` = jumlah_unit * upah_per_unit.
            // Note: MySQL >= 5.7 required. If the DB engine doesn't support generated columns,
            // this statement may fail — handle migration on the target DB accordingly.
            try {
                DB::statement("ALTER TABLE produksi_karyawan_tim ADD COLUMN upah_total BIGINT GENERATED ALWAYS AS (jumlah_unit * upah_per_unit) STORED");
            } catch (\Exception $e) {
                // ignore if DB doesn't support generated columns or column already exists
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi_karyawan_tim');
    }
};
