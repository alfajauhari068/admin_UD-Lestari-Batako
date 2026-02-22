<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * FINAL SPECIFICATION:
     * 
     * Produksi (Master Ongkos):
     * - id_produk (FK)
     * - upah_per_unit
     * - satuan
     * - keterangan
     * 
     * Tim Produksi (Transaksi Harian):
     * - produksi_id (FK)
     * - id_produk (for quick access)
     * - karyawan_id (FK)
     * - tanggal_produksi
     * - jumlah_produksi
     * - upah_per_unit (snapshot)
     * - total_upah (auto-calculated)
     */
    public function up(): void
    {
        // 1. Update tim_produksi table - add fields for transaksi
        Schema::table('tim_produksi', function (Blueprint $table) {
            if (!Schema::hasColumn('tim_produksi', 'id_produk')) {
                $table->unsignedBigInteger('id_produk')->nullable();
            }
            if (!Schema::hasColumn('tim_produksi', 'upah_per_unit')) {
                $table->decimal('upah_per_unit', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('tim_produksi', 'total_upah')) {
                $table->decimal('total_upah', 14, 2)->nullable();
            }
        });

        // 2. Restructure produksis table - master ongkos only
        // First, handle column renaming with raw SQL for safety
        try {
            // Rename produk_id to id_produk
            if (Schema::hasColumn('produksis', 'produk_id') && !Schema::hasColumn('produksis', 'id_produk')) {
                DB::statement('ALTER TABLE produksis CHANGE COLUMN produk_id id_produk BIGINT UNSIGNED NULL');
            }

            // Rename gaji_per_unit to upah_per_unit
            if (Schema::hasColumn('produksis', 'gaji_per_unit') && !Schema::hasColumn('produksis', 'upah_per_unit')) {
                DB::statement('ALTER TABLE produksis CHANGE COLUMN gaji_per_unit upah_per_unit DECIMAL(12,2) DEFAULT 0');
            }
        } catch (\Exception $e) {
            // Continue even if rename fails - columns may already be named correctly
        }

        Schema::table('produksis', function (Blueprint $table) {
            // Add id_produk if not exists at all
            if (!Schema::hasColumn('produksis', 'id_produk')) {
                $table->unsignedBigInteger('id_produk')->nullable();
            }

            // Add upah_per_unit if not exists
            if (!Schema::hasColumn('produksis', 'upah_per_unit')) {
                $table->decimal('upah_per_unit', 12, 2)->default(0);
            }

            // Add satuan
            if (!Schema::hasColumn('produksis', 'satuan')) {
                $table->string('satuan')->default('unit');
            }

            // Add keterangan
            if (!Schema::hasColumn('produksis', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }

            // Drop old fields
            if (Schema::hasColumn('produksis', 'nama_produksi')) {
                $table->dropColumn('nama_produksi');
            }
            if (Schema::hasColumn('produksis', 'kriteria_gaji')) {
                $table->dropColumn('kriteria_gaji');
            }
            if (Schema::hasColumn('produksis', 'jumlah_per_unit')) {
                $table->dropColumn('jumlah_per_unit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produksis', function (Blueprint $table) {
            // Restore old fields
            if (!Schema::hasColumn('produksis', 'nama_produksi')) {
                $table->string('nama_produksi');
            }
            if (!Schema::hasColumn('produksis', 'kriteria_gaji')) {
                $table->string('kriteria_gaji');
            }

            // Rename back
            try {
                if (Schema::hasColumn('produksis', 'upah_per_unit')) {
                    DB::statement('ALTER TABLE produksis CHANGE COLUMN upah_per_unit gaji_per_unit BIGINT DEFAULT 0');
                }
            } catch (\Exception $e) {
                // Continue
            }

            // Drop new fields
            if (Schema::hasColumn('produksis', 'satuan')) {
                $table->dropColumn('satuan');
            }
            if (Schema::hasColumn('produksis', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
            if (Schema::hasColumn('produksis', 'id_produk')) {
                // Rename to produk_id before dropping
                try {
                    DB::statement('ALTER TABLE produksis CHANGE COLUMN id_produk produk_id BIGINT UNSIGNED NULL');
                } catch (\Exception $e) {
                    $table->dropColumn('id_produk');
                }
            }
        });

        Schema::table('tim_produksi', function (Blueprint $table) {
            if (Schema::hasColumn('tim_produksi', 'id_produk')) {
                $table->dropColumn('id_produk');
            }
            if (Schema::hasColumn('tim_produksi', 'upah_per_unit')) {
                $table->dropColumn('upah_per_unit');
            }
            if (Schema::hasColumn('tim_produksi', 'total_upah')) {
                $table->dropColumn('total_upah');
            }
        });
    }
};
