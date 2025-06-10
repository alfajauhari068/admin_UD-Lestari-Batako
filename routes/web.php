<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\RegisterController;

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




Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', [loginController::class, 'logout'])->name('logout');

Route::get('/login', [loginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/log', [loginController::class, 'login'])->name('login.store');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/regist', [RegisterController::class, 'store'])->name('register.store');



Route::middleware(['auth'])->group(function () {
 
  

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'delete'])->name('produk.delete');

    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
    Route::get('/pelanggan/{id}/riwayat', [PelangganController::class, 'riwayat'])->name('pelanggan.riwayat');
    Route::get('/pelanggan-pesan', [PelangganController::class, 'pesan'])->name('pelanggan.pelanggan_pesan');


    
    Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id_pesanan}/detail', [PesananController::class, 'detail'])->name('pesanan.detail');



    Route::get('/detail-pesanan/{id_pesanan}/create', [DetailPesananController::class, 'create'])->name('detail_pesanan.create');
    Route::post('/detail-pesanan/store', [DetailPesananController::class, 'store'])->name('detail_pesanan.store');



    Route::get('/detailpesanan', [DetailPesananController::class, 'index'])->name('detailpesanan.index');
    Route::get('/detailpesanan/{id}', [DetailPesananController::class, 'show'])->name('detailpesanan.show');
    Route::get('/detail-pesanan/{id}/edit', [DetailPesananController::class, 'edit'])->name('detail_pesanan.edit');
    Route::post('/detail-pesanan/{id}/update', [DetailPesananController::class, 'update'])->name('detail_pesanan.update');
    Route::delete('/detail-pesanan/{id}', [DetailPesananController::class, 'destroy'])->name('detail_pesanan.destroy');


    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
    Route::get('/pengiriman/{id_pesanan}/create', [PengirimanController::class, 'create'])->name('pengiriman.create');
    Route::post('/pengiriman/store', [PengirimanController::class, 'store'])->name('pengiriman.store');
    Route::get('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'show'])->name('pengiriman.show');
    Route::get('/pengiriman/{id_pengiriman}/edit', [PengirimanController::class, 'edit'])->name('pengiriman.edit');
    Route::put('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'update'])->name('pengiriman.update');
    Route::delete('/pengiriman/{id_pengiriman}', [PengirimanController::class, 'destroy'])->name('pengiriman.destroy');

    // Route untuk KaryawanController
    Route::get('/karyawans', [KaryawanController::class, 'index'])->name('karyawans.index');
    Route::get('/karyawans/create', [KaryawanController::class, 'create'])->name('karyawans.create_kariawan');
    Route::post('/karyawans', [KaryawanController::class, 'store'])->name('karyawans.store');
    Route::get('/karyawans/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawans.edit');
    Route::put('/karyawans/{karyawan}', [KaryawanController::class, 'update'])->name('karyawans.update');
    Route::delete('/karyawans/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawans.destroy');

    // Route untuk ProduksiController
    Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index'); // Menampilkan daftar produksi
    Route::get('/produksi/create', [ProduksiController::class, 'create'])->name('produksi.create'); // Form tambah produksi
    Route::post('/produksi', [ProduksiController::class, 'store'])->name('produksi.store'); // Menyimpan data produksi
    Route::get('/produksi/{id}/edit', [ProduksiController::class, 'edit'])->name('produksi.edit'); // Form edit produksi
    Route::put('/produksi/{id}', [ProduksiController::class, 'update'])->name('produksi.update'); // Memperbarui data produksi
    Route::delete('/produksi/{id}', [ProduksiController::class, 'destroy'])->name('produksi.destroy'); // Menghapus data produksi

    Route::get('/produksi-karyawan', [ProduksiKaryawanController::class, 'index'])->name('produksi_karyawan.index');
    Route::get('/produksi-karyawan/create', [ProduksiKaryawanController::class, 'create'])->name('produksi_karyawan.create');
    Route::post('/produksi-karyawan', [ProduksiKaryawanController::class, 'store'])->name('produksi_karyawan.store');

    Route::get('/karyawan-produksi', [ProduksiKaryawanController::class, 'index'])->name('karyawan_produksi.index');
    Route::get('/karyawan-produksi/create', [ProduksiKaryawanController::class, 'create'])->name('karyawan_produksi.create');
    Route::post('/karyawan-produksi', [ProduksiKaryawanController::class, 'store'])->name('karyawan_produksi.store');
    Route::get('/karyawan-produksi/detail/{id}', [ProduksiKaryawanController::class, 'detail'])->name('karyawan_produksi.detail');


 });

require __DIR__.'/auth.php';
