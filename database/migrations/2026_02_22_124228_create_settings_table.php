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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Company Settings
            $table->string('company_name')->default('UD. Lestari Batako');
            $table->text('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_npwp')->nullable();

            // UI Settings
            $table->boolean('dark_mode')->default(false);
            $table->boolean('compact_mode')->default(false);
            $table->enum('sidebar_position', ['left', 'right'])->default('left');
            $table->enum('table_density', ['comfortable', 'compact', 'spacious'])->default('comfortable');
            $table->string('date_format')->default('d/m/Y');
            $table->string('currency_format')->default('Rp');

            // System Settings
            $table->string('default_dashboard')->default('dashboard');
            $table->integer('items_per_page')->default(10);
            $table->string('default_order_status')->default('pending');
            $table->string('default_production_status')->default('planned');
            $table->boolean('notify_order')->default(true);
            $table->boolean('notify_production')->default(true);
            $table->boolean('notify_low_stock')->default(true);
            $table->boolean('notify_daily_report')->default(false);
            $table->integer('auto_refresh_interval')->default(0);
            $table->string('language')->default('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
