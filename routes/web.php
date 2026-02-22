<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\KaryawanProduksiController;
use App\Http\Controllers\ProduksiKaryawanTimController;
use App\Http\Controllers\TimProduksiController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Include authentication routes
require __DIR__ . '/auth.php';

// ==============================================================================
// PUBLIC ROUTES (No Authentication Required)
// ==============================================================================

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/kontak', function () {
    return view('public.kontak');
})->name('kontak');

Route::get('/registrasi', [AuthController::class, 'tampilRegistrasi'])->name('registrasi');
Route::get('/pelanggan-pesan', [PelangganController::class, 'pesan'])->name('pelanggan.pesan');

// ==============================================================================
// PROTECTED ROUTES (Authentication Required)
// ==============================================================================

Route::middleware(['auth'])->group(function () {

    // ─────────────────────────────────────────────────────────────
    // DASHBOARD & PROFILE ROUTES
    // ─────────────────────────────────────────────────────────────

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/toggle-dark-mode', [ProfileController::class, 'toggleDarkMode'])
        ->name('profile.toggle-dark-mode');

    // ─────────────────────────────────────────────────────────────
    // SETTINGS ROUTES (Admin Only)
    // ─────────────────────────────────────────────────────────────

    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');

    Route::patch('/settings/company', [App\Http\Controllers\SettingsController::class, 'updateCompany'])->name('settings.company.update');
    Route::patch('/settings/ui', [App\Http\Controllers\SettingsController::class, 'updateUI'])->name('settings.ui.update');
    Route::patch('/settings/system', [App\Http\Controllers\SettingsController::class, 'updateSystem'])->name('settings.system.update');

    // ─────────────────────────────────────────────────────────────
    // PRODUK ROUTES (RESTful) - NOW PROTECTED
    // ─────────────────────────────────────────────────────────────

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id_produk}', [ProdukController::class, 'show'])
        ->name('produk.show')
        ->where('id_produk', '\d+');
    Route::get('/produk/{id_produk}/edit', [ProdukController::class, 'edit'])
        ->name('produk.edit')
        ->where('id_produk', '\d+');
    Route::put('/produk/{id_produk}', [ProdukController::class, 'update'])
        ->name('produk.update')
        ->where('id_produk', '\d+');
    Route::delete('/produk/{id_produk}', [ProdukController::class, 'destroy'])
        ->name('produk.delete')
        ->where('id_produk', '\d+');

    // Export routes - NOW PROTECTED FROM DATA BREACH
    Route::get('/produk/export/csv', [ProdukController::class, 'exportCsv'])
        ->name('produk.export.csv');
    Route::get('/produk/export/pdf', [ProdukController::class, 'exportPdf'])
        ->name('produk.export.pdf');
    Route::get('/produk/export/excel', [ProdukController::class, 'exportExcel'])
        ->name('produk.export.excel');

    // ─────────────────────────────────────────────────────────────
    // PELANGGAN ROUTES (RESTful)
    // ─────────────────────────────────────────────────────────────

    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/{id_pelanggan}', [PelangganController::class, 'show'])
        ->name('pelanggan.show')
        ->where('id_pelanggan', '\d+');
    Route::get('/pelanggan/{id_pelanggan}/edit', [PelangganController::class, 'edit'])
        ->name('pelanggan.edit')
        ->where('id_pelanggan', '\d+');
    Route::put('/pelanggan/{id_pelanggan}', [PelangganController::class, 'update'])
        ->name('pelanggan.update')
        ->where('id_pelanggan', '\d+');
    Route::delete('/pelanggan/{id_pelanggan}', [PelangganController::class, 'destroy'])
        ->name('pelanggan.destroy')
        ->where('id_pelanggan', '\d+');
    Route::get('/pelanggan/{id_pelanggan}/riwayat', [PelangganController::class, 'riwayat'])
        ->name('pelanggan.riwayat')
        ->where('id_pelanggan', '\d+');

    // ─────────────────────────────────────────────────────────────
    // PESANAN ROUTES (RESTful)
    // ─────────────────────────────────────────────────────────────

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{id_pesanan}', [PesananController::class, 'show'])
        ->name('pesanan.show')
        ->where('id_pesanan', '\d+');
    Route::get('/pesanan/{id_pesanan}/detail', [PesananController::class, 'detail'])
        ->name('pesanan.detail')
        ->where('id_pesanan', '\d+');
    Route::get('/pesanan/{id_pesanan}/edit', [PesananController::class, 'edit'])
        ->name('pesanan.edit')
        ->where('id_pesanan', '\d+');
    Route::put('/pesanan/{id_pesanan}', [PesananController::class, 'update'])
        ->name('pesanan.update')
        ->where('id_pesanan', '\d+');
    Route::delete('/pesanan/{id_pesanan}', [PesananController::class, 'destroy'])
        ->name('pesanan.destroy')
        ->where('id_pesanan', '\d+');
    Route::post('/pesanan/{id_pesanan}/confirm', [PesananController::class, 'confirm'])
        ->name('pesanan.confirm')
        ->where('id_pesanan', '\d+');
    Route::post('/pesanan/{id_pesanan}/cancel', [PesananController::class, 'cancel'])
        ->name('pesanan.cancel')
        ->where('id_pesanan', '\d+');
    Route::post('/pesanan/{id_pesanan}/complete', [PesananController::class, 'complete'])
        ->name('pesanan.complete')
        ->where('id_pesanan', '\d+');
    Route::get('/pesanan/export/csv', [PesananController::class, 'exportCsv'])
        ->name('pesanan.export.csv');

    // ─────────────────────────────────────────────────────────────
    // DETAIL PESANAN ROUTES (RESTful)
    // ─────────────────────────────────────────────────────────────

    Route::get('/detail-pesanan', [DetailPesananController::class, 'index'])
        ->name('detail_pesanan.index');

    Route::get('/detail-pesanan/create/{id_pesanan}', [DetailPesananController::class, 'create'])
        ->name('detail_pesanan.create')
        ->where('id_pesanan', '\d+');
    Route::post('/detail-pesanan', [DetailPesananController::class, 'store'])
        ->name('detail_pesanan.store');
    Route::get('/detail-pesanan/{id_detail_pesanan}', [DetailPesananController::class, 'show'])
        ->name('detail_pesanan.show')
        ->where('id_detail_pesanan', '\d+');
    Route::get('/detail-pesanan/{id_detail_pesanan}/edit', [DetailPesananController::class, 'edit'])
        ->name('detail_pesanan.edit')
        ->where('id_detail_pesanan', '\d+');
    Route::put('/detail-pesanan/{id_detail_pesanan}', [DetailPesananController::class, 'update'])
        ->name('detail_pesanan.update')
        ->where('id_detail_pesanan', '\d+');
    Route::delete('/detail-pesanan/{id_detail_pesanan}', [DetailPesananController::class, 'destroy'])
        ->name('detail_pesanan.destroy')
        ->where('id_detail_pesanan', '\d+');

    // ─────────────────────────────────────────────────────────────
    // PENGIRIMAN ROUTES (RESTful)
    // ─────────────────────────────────────────────────────────────

    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
    Route::get('/pengiriman/create', [PengirimanController::class, 'create'])
        ->name('pengiriman.create');
    Route::post('/pengiriman', [PengirimanController::class, 'store'])->name('pengiriman.store');
    Route::get('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'show'])
        ->name('pengiriman.show')
        ->where('id_pengiriman', '\d+');
    Route::get('/pengiriman/{id_pengiriman}/edit', [PengirimanController::class, 'edit'])
        ->name('pengiriman.edit')
        ->where('id_pengiriman', '\d+');
    Route::put('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'update'])
        ->name('pengiriman.update')
        ->where('id_pengiriman', '\d+');
    Route::delete('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'destroy'])
        ->name('pengiriman.destroy')
        ->where('id_pengiriman', '\d+');

    // API endpoint untuk mendapatkan detail pesanan
    Route::get('/api/pesanan/{id}/detail', [PengirimanController::class, 'getPesananDetail'])
        ->name('api.pesanan.detail')
        ->where('id', '\d+');

    // ─────────────────────────────────────────────────────────────
    // KARYAWAN ROUTES (RESTful)
    // ─────────────────────────────────────────────────────────────

    Route::get('/karyawans', [KaryawanController::class, 'index'])->name('karyawans.index');
    Route::get('/karyawans/create', [KaryawanController::class, 'create'])
        ->name('karyawans.create');
    Route::post('/karyawans', [KaryawanController::class, 'store'])->name('karyawans.store');
    Route::get('/karyawans/{id_karyawan}', [KaryawanController::class, 'show'])
        ->name('karyawans.show')
        ->where('id_karyawan', '\d+');
    Route::get('/karyawans/{id_karyawan}/edit', [KaryawanController::class, 'edit'])
        ->name('karyawans.edit')
        ->where('id_karyawan', '\d+');
    Route::put('/karyawans/{id_karyawan}', [KaryawanController::class, 'update'])
        ->name('karyawans.update')
        ->where('id_karyawan', '\d+');
    Route::delete('/karyawans/{id_karyawan}', [KaryawanController::class, 'destroy'])
        ->name('karyawans.destroy')
        ->where('id_karyawan', '\d+');
    Route::get('/karyawan/riwayat', [KaryawanController::class, 'riwayat'])
        ->name('karyawan.riwayat');

    // ─────────────────────────────────────────────────────────────
    // KARYAWAN PRODUKSI ROUTES (RESTful)
    // ─────────────────────────────────────────────────────────────

    Route::get('/karyawan-produksi', [KaryawanProduksiController::class, 'index'])
        ->name('karyawan_produksi.index');
    Route::get('/karyawan-produksi/create', [KaryawanProduksiController::class, 'create'])
        ->name('karyawan_produksi.create');
    Route::post('/karyawan-produksi', [KaryawanProduksiController::class, 'store'])
        ->name('karyawan_produksi.store');
    Route::get('/karyawan-produksi/{id_karyawan_produksi}/edit', [KaryawanProduksiController::class, 'edit'])
        ->name('karyawan_produksi.edit')
        ->where('id_karyawan_produksi', '\d+');
    Route::put('/karyawan-produksi/{id_karyawan_produksi}', [KaryawanProduksiController::class, 'update'])
        ->name('karyawan_produksi.update')
        ->where('id_karyawan_produksi', '\d+');
    Route::delete('/karyawan-produksi/{id_karyawan_produksi}', [KaryawanProduksiController::class, 'destroy'])
        ->name('karyawan_produksi.destroy')
        ->where('id_karyawan_produksi', '\d+');
    Route::get('/karyawan-produksi/{id_karyawan_produksi}', [KaryawanProduksiController::class, 'show'])
        ->name('karyawan_produksi.show')
        ->where('id_karyawan_produksi', '\d+');

    // ─────────────────────────────────────────────────────────────
    // PRODUKSI ROUTES (RESTful)
    // ─────────────────────────────────────────────────────────────

    Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
    Route::get('/produksi/create', [ProduksiController::class, 'create'])
        ->name('produksi.create');
    Route::post('/produksi', [ProduksiController::class, 'store'])->name('produksi.store');
    Route::get('/produksi/{id_produksi}', [ProduksiController::class, 'show'])
        ->name('produksi.show')
        ->where('id_produksi', '\d+');
    Route::get('/produksi/{id_produksi}/edit', [ProduksiController::class, 'edit'])
        ->name('produksi.edit')
        ->where('id_produksi', '\d+');
    Route::put('/produksi/{id_produksi}', [ProduksiController::class, 'update'])
        ->name('produksi.update')
        ->where('id_produksi', '\d+');
    Route::delete('/produksi/{id_produksi}', [ProduksiController::class, 'destroy'])
        ->name('produksi.destroy')
        ->where('id_produksi', '\d+');

    // API endpoint untuk mendapatkan upah per unit produk
    Route::get('/api/produk/{id_produk}/upah', [ProduksiController::class, 'getUpahPerUnit'])
        ->name('api.produk.upah')
        ->where('id_produk', '\d+');

    // ─────────────────────────────────────────────────────────────
    // TIM PRODUKSI ROUTES (Transaksi Harian)
    // ─────────────────────────────────────────────────────────────

    Route::resource('tim-produksi', TimProduksiController::class);

    // API endpoint untuk mendapatkan info master ongkos
    Route::get('/api/produksi/{id_produksi}/info', [TimProduksiController::class, 'getInfo'])
        ->name('api.produksi.info')
        ->where('id_produksi', '\d+');

    // ─────────────────────────────────────────────────────────────
    // PRODUKSI KARYAWAN TIM ROUTES (legacy views under resources/views/produksi_karyawan_tim)
    // Provide explicit underscored names so views can call route('produksi_karyawan_tim.index') etc.
    Route::resource('produksi-karyawan-tim', ProduksiKaryawanTimController::class)->names([
        'index' => 'produksi_karyawan_tim.index',
        'create' => 'produksi_karyawan_tim.create',
        'store' => 'produksi_karyawan_tim.store',
        'show' => 'produksi_karyawan_tim.show',
        'edit' => 'produksi_karyawan_tim.edit',
        'update' => 'produksi_karyawan_tim.update',
        'destroy' => 'produksi_karyawan_tim.destroy',
    ]);

    // Additional group-level routes for operasi berdasarkan produksi + tanggal
    Route::get('/produksi-karyawan-tim/{id}/{tanggal}', [ProduksiKaryawanTimController::class, 'detailByProduction'])
        ->name('produksi_karyawan_tim.detail')
        ->where('id', '\d+');

    Route::get('/produksi-karyawan-tim/{id}/{tanggal}/edit', [ProduksiKaryawanTimController::class, 'editByProduction'])
        ->name('produksi_karyawan_tim.edit_group')
        ->where('id', '\d+');

    Route::delete('/produksi-karyawan-tim/{id}/{tanggal}', [ProduksiKaryawanTimController::class, 'destroyByProduction'])
        ->name('produksi_karyawan_tim.destroy_group')
        ->where('id', '\d+');

    // Legacy routes - redirect to new tim-produksi routes

}); // End of auth middleware group

// ==============================================================================
// LEGACY ROUTE HANDLERS - LOCKED DOWN
// ==============================================================================
// These routes intentionally return 404 to enforce canonical routing.
// All functionality has been migrated to canonical routes defined above.

Route::any('/produksi-karyawan{any?}', function () {
    abort(404);
})->where('any', '.*');

Route::any('/produksi-karyawan-tim{any?}', function () {
    abort(404);
})->where('any', '.*');



