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
        Schema::table('pengirimen', function (Blueprint $table) {
            // Hapus kolom yang tidak diperlukan jika ada
            if (Schema::hasColumn('pengirimen', 'jasa_kurir')) {
                $table->dropColumn('jasa_kurir');
            }
            if (Schema::hasColumn('pengirimen', 'no_resi')) {
                $table->dropColumn('no_resi');
            }
            
            // Tambah kolom baru untuk GPS dan jenis pengiriman
            $table->decimal('latitude', 10, 8)->nullable()->after('alamat_pengiriman');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('kecamatan', 100)->nullable()->after('longitude');
            $table->string('kabupaten', 100)->nullable()->after('kecamatan');
            $table->string('provinsi', 100)->nullable()->after('kabupaten');
            $table->enum('jenis_pengiriman', ['Internal / Ambil Sendiri', 'Kurir Lokal', 'Ekspedisi'])->default('Internal / Ambil Sendiri')->after('provinsi');
            $table->enum('status', ['Menunggu Dijadwalkan', 'Dalam Pengiriman', 'Terkirim', 'Dibatalkan'])->default('Menunggu Dijadwalkan')->after('jenis_pengiriman');
            $table->text('catatan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengirimen', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'kecamatan',
                'kabupaten',
                'provinsi',
                'jenis_pengiriman',
                'status',
                'catatan'
            ]);
            
            // Kembalikan kolom lama
            $table->string('jasa_kurir', 100)->nullable();
            $table->string('no_resi', 100)->nullable();
        });
    }
};
