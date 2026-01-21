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
    // Drop the old `produksi_karyawans` table if it exists.
    // This is safe because no other migrations reference this table (verified).
    // If you have application code still depending on it, stop and update code first.
    Schema::dropIfExists('produksi_karyawans');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Recreate the original table schema so the migration is reversible.
    Schema::create('produksi_karyawans', function (Blueprint $table) {
      $table->id(); // Primary Key
      $table->unsignedBigInteger('id_produksi'); // FK ke produksis
      $table->date('tanggal_produksi'); // Tanggal produksi
      $table->integer('jumlah_unit'); // Contoh: 400
      $table->bigInteger('upah_total'); // Otomatis dihitung in newer design
      $table->timestamps();

      // Recreate foreign key to `produksis` as before
      $table->foreign('id_produksi')->references('id_produksi')->on('produksis')->onDelete('cascade');
    });
  }
};
