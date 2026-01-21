<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\ProduksiKaryawanTim;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProduksiController extends Controller
{
    public function index()
    {
        $produksis = Produksi::all();
        return view('produksi.dashboard_produksi', compact('produksis'));
    }

    public function create()
    {
        // Ambil master produk untuk dropdown
        $produks = Produk::all();
        $karyawans = Karyawan::all();

        // Kirim data ke view
        return view('produksi.create_produksi', compact('produks', 'karyawans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'kriteria_gaji' => 'required|string|max:255',
            'gaji_per_unit' => 'required|integer|min:1',
            'jumlah_per_unit' => 'required|integer|min:1',
        ]);

        Produksi::create($validatedData);

        return redirect()->route('produksi.index')->with('success', 'Produksi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $produksi = Produksi::findOrFail($id);
        return view('produksi.show_produksi', compact('produksi'));
    }

    /**
     * Detail by produksi id and tanggal (canonical)
     * route: /produksi/{id}/{tanggal}
     */
    public function detailByDate($id, $tanggal)
    {
        $produksi = Produksi::findOrFail($id);
        $tanggalCarbon = Carbon::parse($tanggal)->toDateString();

        $total_unit = ProduksiKaryawanTim::where('id_produksi', $id)
            ->whereDate('tanggal_produksi', $tanggalCarbon)
            ->sum('jumlah_unit');

        $jumlah_anggota = ProduksiKaryawanTim::where('id_produksi', $id)
            ->whereDate('tanggal_produksi', $tanggalCarbon)
            ->distinct('id_karyawan')
            ->count('id_karyawan');

        return view('produksi.show_produksi', compact('produksi', 'tanggalCarbon', 'total_unit', 'jumlah_anggota'));
    }

    public function edit($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produks = Produk::all();
        return view('produksi.edit_produksi', compact('produksi', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $produksi = Produksi::findOrFail($id);
        $validatedData = $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'kriteria_gaji' => 'required|string|max:255',
            'gaji_per_unit' => 'required|integer|min:1',
            'jumlah_per_unit' => 'required|integer|min:1',
        ]);

        $produksi->update($validatedData);

        return redirect()->route('produksi.index')->with('success', 'Data produksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari data produksi berdasarkan ID
        $produksi = Produksi::findOrFail($id);

        // Hapus data produksi
        $produksi->delete();

        // Redirect ke halaman dashboard dengan pesan sukses
        return redirect()->route('produksi.index')->with('success', 'Produksi berhasil dihapus.');
    }
}
