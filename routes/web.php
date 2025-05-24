<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailPesananController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');


Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');

Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');

Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');

// Untuk menampilkan form edit
Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');

// Untuk memproses update data
Route::put('produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');

Route::delete('/produk/{produk}', [ProdukController::class, 'delete'])->name('produk.delete');



Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');

Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');

Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');

Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');

Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');


Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');

Route::get('/pelanggan/{id}/riwayat', [PelangganController::class, 'riwayat'])->name('pelanggan.riwayat');

Route::get('/pesanan/create/{id_pelanggan}', [PesananController::class, 'create'])->name('pesanan.create');
Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
Route::get('/pesanan/{id}/detail', [PesananController::class, 'show'])->name('pesanan.show');
Route::get('/pesanan/{id}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
Route::put('/pesanan/{id}', [PesananController::class, 'update'])->name('pesanan.update');
Route::delete('/pesanan/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
Route::get('/pesanan/{id}/export-pdf', [PesananController::class, 'exportPdf'])->name('pesanan.exportPdf');



Route::get('/pengiriman', function () {
    return 'Halaman pengiriman belum tersedia';
})->name('pengiriman.index');



Route::get('/pelanggan-pesan', [PelangganController::class, 'pesan'])->name('pelanggan.pelanggan_pesan');

Route::resource('detailpesanan', DetailPesananController::class);

