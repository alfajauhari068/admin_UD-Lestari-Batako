<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'company_name' => 'UD. Lestari Batako',
            'company_address' => 'Jl. Contoh No. 123, Kota Contoh, Provinsi Contoh',
            'company_phone' => '0812-3456-7890',
            'company_email' => 'info@lestaribatako.com',
            'company_website' => 'https://www.lestaribatako.com',
            'company_npwp' => '12.345.678.9-012.345',
            'dark_mode' => false,
            'compact_mode' => false,
            'sidebar_position' => 'left',
            'table_density' => 'comfortable',
            'date_format' => 'd/m/Y',
            'currency_format' => 'Rp',
            'default_dashboard' => 'dashboard',
            'items_per_page' => 10,
            'default_order_status' => 'pending',
            'default_production_status' => 'planned',
            'notify_order' => true,
            'notify_production' => true,
            'notify_low_stock' => true,
            'notify_daily_report' => false,
            'auto_refresh_interval' => 0,
            'language' => 'id',
        ]);
    }
}
