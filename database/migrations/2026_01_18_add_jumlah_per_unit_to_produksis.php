<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * KONTEKS:
   * Tabel produksis adalah referensi patokan produksi:
   * - jumlah_per_unit: patokan kuantitas (contoh: 100 biji)
   * - gaji_per_unit: gaji untuk 1 patokan unit (contoh: 50.000)
   */
  public function up(): void
  {
    Schema::table('produksis', function (Blueprint $table) {
      // Tambahkan kolom jumlah_per_unit jika belum ada
      if (!Schema::hasColumn('produksis', 'jumlah_per_unit')) {
        // Gunakan after('id_produksi') jika nama_produksi sudah dihapus
        if (Schema::hasColumn('produksis', 'nama_produksi')) {
          $table->integer('jumlah_per_unit')->default(100)->after('nama_produksi');
        } else {
          $table->integer('jumlah_per_unit')->default(100)->after('id_produksi');
        }
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('produksis', function (Blueprint $table) {
      if (Schema::hasColumn('produksis', 'jumlah_per_unit')) {
        $table->dropColumn('jumlah_per_unit');
      }
    });
  }
};
