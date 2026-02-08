<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   * 
   * Creates unified tim_produksi table as single-source-of-truth for:
   * - Team membership tracking
   * - Per-worker contribution
   * - Automatic salary calculation readiness
   */
  public function up(): void
  {
    if (!Schema::hasTable('tim_produksi')) {
      Schema::create('tim_produksi', function (Blueprint $table) {
        $table->id();

        // Foreign Keys
        $table->unsignedBigInteger('id_produksi');
        $table->unsignedBigInteger('id_karyawan');

        // Tracking Data
        $table->integer('jumlah_produksi')->default(0);
        $table->date('tanggal_produksi');

        // Timestamps
        $table->timestamps();

        // Constraints: Ensure one record per karyawan per produksi per tanggal
        $table->unique(['id_produksi', 'id_karyawan', 'tanggal_produksi'], 'unique_tim_produksi');

        // Foreign Keys with cascade delete
        $table->foreign('id_produksi')
          ->references('id_produksi')
          ->on('produksis')
          ->onDelete('cascade')
          ->onUpdate('cascade');

        $table->foreign('id_karyawan')
          ->references('id_karyawan')
          ->on('karyawans')
          ->onDelete('cascade')
          ->onUpdate('cascade');

        // Indexes untuk query optimization
        $table->index('id_produksi');
        $table->index('id_karyawan');
        $table->index('tanggal_produksi');
        $table->index(['id_produksi', 'tanggal_produksi']);
        $table->index(['id_karyawan', 'tanggal_produksi']);
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tim_produksi');
  }
};
