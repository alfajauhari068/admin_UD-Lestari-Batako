<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Menambahkan field upah_per_unit ke tabel produks
     * untuk menentukan upah karyawan per unit produk yang diproduksi
     */
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Tambah kolom upah_per_unit setelah harga_satuan
            $table->decimal('upah_per_unit', 10, 2)->default(0)->after('harga_satuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn('upah_per_unit');
        });
    }
};
