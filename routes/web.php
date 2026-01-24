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
use App\Http\Controllers\ProduksiKaryawanController;
use App\Http\Controllers\KaryawanProduksiController;
use App\Http\Controllers\ProduksiKaryawanTimController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/kontak', function () {
    return view('public.kontak');
})->name('kontak');

Route::get('/registrasi', [AuthController::class, 'tampilRegistrasi'])->name('registrasi');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Produk Routes (RESTful)
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{id_produk}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/produk/{id_produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id_produk}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id_produk}', [ProdukController::class, 'destroy'])->name('produk.delete');
// Export routes (CSV / PDF) - permission guarded in controller
Route::get('/produk/export/csv', [ProdukController::class, 'exportCsv'])->name('produk.export.csv');
Route::get('/produk/export/pdf', [ProdukController::class, 'exportPdf'])->name('produk.export.pdf');
Route::get('/produk/export/excel', [ProdukController::class, 'exportExcel'])->name('produk.export.excel');

// Pelanggan Routes (RESTful)
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::get('/pelanggan/{id_pelanggan}', [PelangganController::class, 'show'])->name('pelanggan.show');
Route::get('/pelanggan/{id_pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::put('/pelanggan/{id_pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::delete('/pelanggan/{id_pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
Route::get('/pelanggan/{id_pelanggan}/riwayat', [PelangganController::class, 'riwayat'])->name('pelanggan.riwayat');
Route::get('/pelanggan-pesan', [PelangganController::class, 'pesan'])->name('pelanggan.pesan');
Route::middleware(['auth'])->group(function () {
    Route::post('/profile/toggle-dark-mode', [ProfileController::class, 'toggleDarkMode'])->name('profile.toggle-dark-mode');
});

// Pesanan Routes (RESTful)
Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
Route::get('/pesanan/{id_pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
Route::get('/pesanan/{id_pesanan}/detail', [PesananController::class, 'detail'])->name('pesanan.detail');
// Export
Route::get('/pesanan/export/csv', [PesananController::class, 'exportCsv'])->name('pesanan.export.csv');
Route::get('/pesanan/{id_pesanan}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
Route::put('/pesanan/{id_pesanan}', [PesananController::class, 'update'])->name('pesanan.update');
Route::delete('/pesanan/{id_pesanan}', [PesananController::class, 'destroy'])->name('pesanan.destroy');

// Detail Pesanan Routes (RESTful)
Route::get('/detail-pesanan', [DetailPesananController::class, 'index'])->name('detail_pesanan.index');
// Accept legacy query-style URLs like /detail-pesanan/create?1 and redirect to the proper route
Route::get('/detail-pesanan/create', function (Request $request) {
    $qs = $request->server('QUERY_STRING');
    if (preg_match('/^\d+$/', $qs)) {
        return redirect()->route('detail_pesanan.create', ['id_pesanan' => $qs]);
    }
    return abort(404);
});
Route::get('/detail-pesanan/create/{id_pesanan}', [DetailPesananController::class, 'create'])->name('detail_pesanan.create');
Route::post('/detail-pesanan', [DetailPesananController::class, 'store'])->name('detail_pesanan.store');
Route::get('/detail-pesanan/{id_detail_pesanan}', [DetailPesananController::class, 'show'])->name('detail_pesanan.show');
Route::get('/detail-pesanan/{id_detail_pesanan}/edit', [DetailPesananController::class, 'edit'])->name('detail_pesanan.edit');
Route::put('/detail-pesanan/{id_detail_pesanan}', [DetailPesananController::class, 'update'])->name('detail_pesanan.update');
Route::delete('/detail-pesanan/{id_detail_pesanan}', [DetailPesananController::class, 'destroy'])->name('detail_pesanan.destroy');

// Pengiriman Routes (RESTful)
Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
Route::get('/pengiriman/create/{id_pesanan}', [PengirimanController::class, 'create'])->name('pengiriman.create');
Route::post('/pengiriman', [PengirimanController::class, 'store'])->name('pengiriman.store');
Route::get('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'show'])->name('pengiriman.show');
Route::get('/pengiriman/{id_pengiriman}/edit', [PengirimanController::class, 'edit'])->name('pengiriman.edit');
Route::put('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'update'])->name('pengiriman.update');
Route::delete('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'destroy'])->name('pengiriman.destroy');

// Karyawan Routes (RESTful)
Route::get('/karyawans', [KaryawanController::class, 'index'])->name('karyawans.index');
Route::get('/karyawans/create', [KaryawanController::class, 'create'])->name('karyawans.create_kariawan');
Route::post('/karyawans', [KaryawanController::class, 'store'])->name('karyawans.store');
Route::get('/karyawans/{id_karyawan}', [KaryawanController::class, 'show'])->name('karyawans.show');
Route::get('/karyawans/{id_karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawans.edit');
Route::put('/karyawans/{id_karyawan}', [KaryawanController::class, 'update'])->name('karyawans.update');
Route::delete('/karyawans/{id_karyawan}', [KaryawanController::class, 'destroy'])->name('karyawans.destroy');
Route::get('/karyawan-produksi', [KaryawanProduksiController::class, 'index'])->name('karyawan_produksi.index');
Route::get('/karyawan-produksi/create', [KaryawanProduksiController::class, 'create'])->name('karyawan_produksi.create');
Route::post('/karyawan-produksi', [KaryawanProduksiController::class, 'store'])->name('karyawan_produksi.store');
Route::get('/karyawan-produksi/{id}/edit', [KaryawanProduksiController::class, 'edit'])->name('karyawan_produksi.edit');
Route::put('/karyawan-produksi/{id}', [KaryawanProduksiController::class, 'update'])->name('karyawan_produksi.update');
Route::delete('/karyawan-produksi/{id}', [KaryawanProduksiController::class, 'destroy'])->name('karyawan_produksi.destroy');


// Produksi Routes (RESTful)
Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
Route::get('/produksi/create', [ProduksiController::class, 'create'])->name('produksi.create_produksi');
Route::post('/produksi', [ProduksiController::class, 'store'])->name('produksi.store');
Route::get('/produksi/{id_produksi}', [ProduksiController::class, 'show'])->name('produksi.show');
Route::get('/produksi/{id_produksi}/edit', [ProduksiController::class, 'edit'])->name('produksi.edit');
Route::put('/produksi/{id_produksi}', [ProduksiController::class, 'update'])->name('produksi.update');
Route::delete('/produksi/{id_produksi}', [ProduksiController::class, 'destroy'])->name('produksi.destroy');

// PRODUKSI KARYAWAN (LEGACY) - LOCKED DOWN
// All legacy produksi-karyawan routes are intentionally disabled. Any attempt to call
// them will return 404 to enforce canonical routing under /produksi and /tim-produksi.
Route::any('/produksi-karyawan{any?}', function () {
    abort(404);
})->where('any', '.*');

// TIM PRODUKSI - canonical routes
Route::get('/tim-produksi', [ProduksiKaryawanTimController::class, 'index'])->name('tim_produksi.index');
Route::get('/tim-produksi/{id}/{tanggal}', [ProduksiKaryawanTimController::class, 'detailByProduction'])->name('tim_produksi.detail');
// Create / Store for tim produksi
Route::get('/tim-produksi/create', [ProduksiKaryawanTimController::class, 'create'])->name('tim_produksi.create');
Route::post('/tim-produksi', [ProduksiKaryawanTimController::class, 'store'])->name('tim_produksi.store');

// Member-level routes for individual anggota (show / edit / update / delete)
Route::get('/tim-produksi/member/{id}', [ProduksiKaryawanTimController::class, 'show'])->name('tim_produksi.member.show');
Route::get('/tim-produksi/member/{id}/edit', [ProduksiKaryawanTimController::class, 'edit'])->name('tim_produksi.member.edit');
Route::put('/tim-produksi/member/{id}', [ProduksiKaryawanTimController::class, 'update'])->name('tim_produksi.member.update');
Route::delete('/tim-produksi/member/{id}', [ProduksiKaryawanTimController::class, 'destroy'])->name('tim_produksi.member.destroy');

// Group-level edit and delete by produksi id + tanggal
Route::get('/tim-produksi/{id}/{tanggal}/edit', [ProduksiKaryawanTimController::class, 'editByProduction'])->name('tim_produksi.edit');
Route::delete('/tim-produksi/{id}/{tanggal}', [ProduksiKaryawanTimController::class, 'destroyByProduction'])->name('tim_produksi.destroy');

// PRODUKSI KARYAWAN TIM (LEGACY) - LOCKED DOWN
Route::any('/produksi-karyawan-tim{any?}', function () {
    abort(404);
})->where('any', '.*');

// Backward-compatible aliases (canonical)
Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
Route::get('/produksi/{id}/{tanggal}', [ProduksiController::class, 'detailByDate'])->name('produksi.detail');

// Karyawan riwayat canonical
Route::get('/karyawan/riwayat', [KaryawanController::class, 'riwayat'])->name('karyawan.riwayat');



