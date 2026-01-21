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
    Schema::table('produksis', function (Blueprint $table) {
      // Add id_produk as nullable first to avoid breaking existing rows
      if (!Schema::hasColumn('produksis', 'id_produk')) {
        $table->unsignedBigInteger('id_produk')->nullable()->after('nama_produksi');
      }

      // Add foreign key if produk table exists and column not yet constrained
      // Note: some DB setups may require separate statements for adding FK.
    });

    // Add foreign key constraint separately to avoid index issues
    if (Schema::hasColumn('produksis', 'id_produk')) {
      try {
        Schema::table('produksis', function (Blueprint $table) {
          $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('set null');
        });
      } catch (\Exception $e) {
        // Ignore if FK cannot be added (e.g., already exists or DB engine differences)
      }
    }

    // Finally, drop the old nama_produksi column if present
    if (Schema::hasColumn('produksis', 'nama_produksi')) {
      Schema::table('produksis', function (Blueprint $table) {
        $table->dropColumn('nama_produksi');
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('produksis', function (Blueprint $table) {
      if (!Schema::hasColumn('produksis', 'nama_produksi')) {
        $table->string('nama_produksi')->after('id_produksi');
      }

      if (Schema::hasColumn('produksis', 'id_produk')) {
        // Drop foreign key if exists
        try {
          $table->dropForeign(['id_produk']);
        } catch (\Exception $e) {
          // ignore
        }
        $table->dropColumn('id_produk');
      }
    });
  }
};
