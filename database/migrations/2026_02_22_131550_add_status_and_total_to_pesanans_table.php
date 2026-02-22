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
        Schema::table('pesanans', function (Blueprint $table) {
            // Add tanggal_pesanan if it doesn't exist
            if (!Schema::hasColumn('pesanans', 'tanggal_pesanan')) {
                $table->date('tanggal_pesanan')->nullable()->after('id_pelanggan');
            }

            // Note: status column already exists from previous migration
            // Note: total_harga column is now handled by a separate migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Note: We don't drop status and tanggal_pesanan as they might be used by other migrations
            // Note: total_harga is handled by a separate migration
        });
    }
};
