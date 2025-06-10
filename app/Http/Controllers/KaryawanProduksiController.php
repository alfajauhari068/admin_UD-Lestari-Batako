<?php
use App\Models\ProduksiKaryawan;
use App\Models\Karyawan;
use App\Models\Produksi;

public function index(Request $request)
{
    // Ambil data produksi karyawan dengan relasi karyawan dan produksi
    $produksiKaryawans = ProduksiKaryawan::with(['karyawan', 'produksi'])->get();

    // Kirim data ke view
    return view('karyawan_produksi.dashboard_produksi_karyawan', compact('produksiKaryawans'));
}