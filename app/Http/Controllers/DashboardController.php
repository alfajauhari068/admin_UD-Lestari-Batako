<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    public function index()
    {
        
        $totalProduk = Produk::count();

        
        $produkKritis = Produk::where('stok_tersedia', '<', 10)->count();

        
        $pesananHariIni = Pesanan::whereDate('created_at', now()->toDateString())->count();

        
        $pesananTerbaru = Pesanan::with(['pelanggan', 'detailPesanan.produk'])->latest()->take(5)->get();

        
        return view('dashboard', compact('totalProduk', 'produkKritis', 'pesananHariIni', 'pesananTerbaru'));
    }
}