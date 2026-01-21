<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Add `upah_per_unit` if it doesn't exist
    if (!Schema::hasColumn('produksi_karyawan_tim', 'upah_per_unit')) {
      Schema::table('produksi_karyawan_tim', function (Blueprint $table) {
        $table->bigInteger('gaji_per_unit')->default(0)->after('id_karyawan');
      });
    }

    // If `upah_total` does not exist but you prefer DB-generated column,
    // that should be handled separately because some DB engines require
    // adding generated columns via raw statements. We keep this migration focused.
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    if (Schema::hasColumn('produksi_karyawan_tim', 'gaji_per_unit')) {
      Schema::table('produksi_karyawan_tim', function (Blueprint $table) {
        $table->dropColumn('gaji_per_unit');
      });
    }
  }
};
