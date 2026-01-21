<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('produksis')) {
            Schema::create('produksis', function (Blueprint $table) {
                $table->id('id_produksi'); // Primary Key
                $table->string('nama_produksi'); // Contoh: Batako Press
                $table->string('kriteria_gaji'); // Contoh: "Per 400 biji / 4 orang"
                $table->bigInteger('gaji_per_unit'); // Contoh: 100000
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};

