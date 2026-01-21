<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\ProduksiKaryawanTim;

class DashboardController extends Controller
{
    public function index()
    {
        
        $totalProduk = Produk::count();

        
        $produkKritis = Produk::where('stok_tersedia', '<', 10)->count();

        
        $pesananHariIni = Pesanan::whereDate('created_at', now()->toDateString())->count();

        
        $pesananTerbaru = Pesanan::with(['pelanggan', 'detailPesanan.produk'])->latest()->take(5)->get();

        $produksiKaryawanTims = ProduksiKaryawanTim::with(['produksi', 'karyawan'])->get();
        $historyProduksiKaryawan = ProduksiKaryawanTim::with(['produksi', 'karyawan'])->orderBy('tanggal_produksi', 'desc')->limit(10)->get();

        
        return view('dashboard', compact('totalProduk', 'produkKritis', 'pesananHariIni', 'pesananTerbaru', 'produksiKaryawanTims', 'historyProduksiKaryawan'));
    }

    
}