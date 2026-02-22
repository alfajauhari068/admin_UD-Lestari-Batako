<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'company_website',
        'company_npwp',
        'dark_mode',
        'compact_mode',
        'sidebar_position',
        'table_density',
        'date_format',
        'currency_format',
        'default_dashboard',
        'items_per_page',
        'default_order_status',
        'default_production_status',
        'notify_order',
        'notify_production',
        'notify_low_stock',
        'notify_daily_report',
        'auto_refresh_interval',
        'language',
    ];

    protected $casts = [
        'dark_mode' => 'boolean',
        'compact_mode' => 'boolean',
        'notify_order' => 'boolean',
        'notify_production' => 'boolean',
        'notify_low_stock' => 'boolean',
        'notify_daily_report' => 'boolean',
        'items_per_page' => 'integer',
        'auto_refresh_interval' => 'integer',
    ];

    /**
     * Get the first (and only) settings record
     */
    public static function getSettings()
    {
        return static::first() ?? static::createDefaultSettings();
    }

    /**
     * Create default settings if none exist
     */
    private static function createDefaultSettings()
    {
        return static::create([
            'company_name' => 'UD. Lestari Batako',
            'company_address' => null,
            'company_phone' => null,
            'company_email' => null,
            'company_website' => null,
            'company_npwp' => null,
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

    /**
     * Get settings grouped by category
     */
    public function getGroupedSettings()
    {
        return [
            'company' => [
                'name' => $this->company_name,
                'address' => $this->company_address,
                'phone' => $this->company_phone,
                'email' => $this->company_email,
                'website' => $this->company_website,
                'npwp' => $this->company_npwp,
            ],
            'ui' => [
                'dark_mode' => $this->dark_mode,
                'compact_mode' => $this->compact_mode,
                'sidebar_position' => $this->sidebar_position,
                'table_density' => $this->table_density,
                'date_format' => $this->date_format,
                'currency_format' => $this->currency_format,
            ],
            'system' => [
                'default_dashboard' => $this->default_dashboard,
                'items_per_page' => $this->items_per_page,
                'default_order_status' => $this->default_order_status,
                'default_production_status' => $this->default_production_status,
                'notify_order' => $this->notify_order,
                'notify_production' => $this->notify_production,
                'notify_low_stock' => $this->notify_low_stock,
                'notify_daily_report' => $this->notify_daily_report,
                'auto_refresh_interval' => $this->auto_refresh_interval,
                'language' => $this->language,
            ],
        ];
    }
}
