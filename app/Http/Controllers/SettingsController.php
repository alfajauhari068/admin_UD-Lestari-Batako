<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = Setting::getSettings();
        $groupedSettings = $settings->getGroupedSettings();

        return view('settings.index', [
            'company' => $groupedSettings['company'],
            'ui' => $groupedSettings['ui'],
            'system' => $groupedSettings['system'],
        ]);
    }

    /**
     * Update company settings
     */
    public function updateCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string|max:1000',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_website' => 'nullable|url|max:255',
            'company_npwp' => 'nullable|string|max:25',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'company');
        }

        $settings = Setting::getSettings();
        $settings->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'company_email' => $request->company_email,
            'company_website' => $request->company_website,
            'company_npwp' => $request->company_npwp,
        ]);

        return back()->with('company_success', 'Informasi perusahaan berhasil diperbarui.');
    }

    /**
     * Update UI settings
     */
    public function updateUI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dark_mode' => 'nullable|boolean',
            'compact_mode' => 'nullable|boolean',
            'sidebar_position' => 'required|in:left,right',
            'table_density' => 'required|in:comfortable,compact,spacious',
            'date_format' => 'required|in:d/m/Y,Y-m-d,d M Y,M d, Y',
            'currency_format' => 'required|in:Rp,IDR,Rp ,Rp',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'ui');
        }

        $settings = Setting::getSettings();
        $settings->update([
            'dark_mode' => $request->has('dark_mode'),
            'compact_mode' => $request->has('compact_mode'),
            'sidebar_position' => $request->sidebar_position,
            'table_density' => $request->table_density,
            'date_format' => $request->date_format,
            'currency_format' => $request->currency_format,
        ]);

        return back()->with('ui_success', 'Pengaturan tampilan berhasil diperbarui.');
    }

    /**
     * Update system settings
     */
    public function updateSystem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'default_dashboard' => 'required|in:dashboard,produk,pesanan,produksi',
            'items_per_page' => 'required|integer|min:5|max:100',
            'default_order_status' => 'required|in:pending,confirmed,processing',
            'default_production_status' => 'required|in:planned,in_progress,completed',
            'notify_order' => 'nullable|boolean',
            'notify_production' => 'nullable|boolean',
            'notify_low_stock' => 'nullable|boolean',
            'notify_daily_report' => 'nullable|boolean',
            'auto_refresh_interval' => 'required|integer|min:0|max:300',
            'language' => 'required|in:id,en',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'system');
        }

        $settings = Setting::getSettings();
        $settings->update([
            'default_dashboard' => $request->default_dashboard,
            'items_per_page' => $request->items_per_page,
            'default_order_status' => $request->default_order_status,
            'default_production_status' => $request->default_production_status,
            'notify_order' => $request->has('notify_order'),
            'notify_production' => $request->has('notify_production'),
            'notify_low_stock' => $request->has('notify_low_stock'),
            'notify_daily_report' => $request->has('notify_daily_report'),
            'auto_refresh_interval' => $request->auto_refresh_interval,
            'language' => $request->language,
        ]);

        return back()->with('system_success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
