<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.dashboard_pelanggan', ['KurirData' => $pelanggan]);
    }

    public function pesan()
    {
        $pesanans = Pesanan::with('pelanggan')->get();
        return view('pelanggan.pelanggan_pesan', ['pesanans' => $pesanans]);
    }

    public function create()
    {
        return view('pelanggan.form_tambah_pelanggan');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        Pelanggan::create($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function riwayat($id_pelanggan)
    {
        $pelanggan = Pelanggan::with(['pesanans.detailPesanan.produk'])->findOrFail($id_pelanggan);
        return view('pelanggan.riwayat_pembelian', compact('pelanggan'));
    }

    public function edit($id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);
        return view('pelanggan.edit_pelanggan', compact('pelanggan'));
    }

    public function update(Request $request, $id_pelanggan)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:500',
        ]);

        $pelanggan = Pelanggan::findOrFail($id_pelanggan);
        $pelanggan->update($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
