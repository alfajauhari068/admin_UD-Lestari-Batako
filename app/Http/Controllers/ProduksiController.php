<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function index()
    {
        $produksis = Produksi::all();
        return view('produksi.dashboard_produksi', compact('produksis'));
    }

    public function create()
    {
        // Ambil data produksi dari database
        $produksis = Produksi::all(); // Pastikan model Produksi sudah diimport

        // Ambil data karyawan dari database
        $karyawans = Karyawan::all(); // Pastikan model Karyawan sudah diimport

        // Kirim data ke view
        return view('produksi.create_produksi', compact('produksis', 'karyawans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produksi' => 'required|string|max:255',
            'kriteria_gaji' => 'required|string|max:255',
            'gaji_per_unit' => 'required|integer|min:1',
        ]);

        Produksi::create($validatedData);

        return redirect()->route('produksi.index')->with('success', 'Produksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produksi = Produksi::findOrFail($id);
        return view('produksi.edit_produksi', compact('produksi'));
    }

    public function update(Request $request, $id)
    {
        $produksi = Produksi::findOrFail($id);

        $validatedData = $request->validate([
            'nama_produksi' => 'required|string|max:255',
            'kriteria_gaji' => 'required|string|max:255',
            'gaji_per_unit' => 'required|integer|min:1',
        ]);

        $produksi->update($validatedData);

        return redirect()->route('produksi.index')->with('success', 'Data produksi berhasil diperbarui.');
    }

    public function destroy(Produksi $produksi)
    {
        $produksi->delete();
        return redirect()->route('produksi.index')->with('success', 'Produksi berhasil dihapus.');
    }
}
