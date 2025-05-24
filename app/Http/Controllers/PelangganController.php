<?php

namespace App\Http\Controllers;
use App\Models\Pelanggan;
use App\Models\pesanan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
public function index()
{
    $pelanggans = Pelanggan::all();
    return view('pelanggan.dashboard_pelanggan', compact('pelanggans'));
}

public function pesan()
{
    $DataPesan = Pesanan::with('pelanggan')->get(); // Memuat relasi pelanggan
    return view('pelanggan.pelanggan_pesan', compact('DataPesan'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'nama' => 'required|string|max:100',
        'email' => 'nullable|email|max:255',
        'no_hp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string',
    ]);

    // Tambahkan data pelanggan ke database
    $pelanggan = Pelanggan::create($validatedData);

    // Redirect ke form tambah pesanan dengan id_pelanggan
    return redirect()->route('pesanan.create', $pelanggan->id_pelanggan)->with('success', 'Pelanggan berhasil ditambahkan. Silakan isi pesanan.');
}
public function create()
{
    return view('pelanggan.form_tambah_pelanggan');
}
public function riwayat($id)
{
    // Ambil data pelanggan beserta riwayat pesanannya
    $pelanggan = Pelanggan::with('pesanans.detailPesanan.produk')->findOrFail($id);

    // Tampilkan view riwayat_pembelian.blade.php dengan data pelanggan
    return view('pelanggan.riwayat_pembelian', compact('pelanggan'));
}
public function edit($id)
{
    $pelanggan = Pelanggan::findOrFail($id); // Ambil data pelanggan berdasarkan ID
    return view('pelanggan.edit_pelanggan', compact('pelanggan'));
}
public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'no_hp' => 'nullable|string|max:15',
        'alamat' => 'nullable|string|max:500',
    ]);

    $pelanggan = Pelanggan::findOrFail($id); // Cari pelanggan berdasarkan ID
    $pelanggan->update($validatedData); // Update data pelanggan

    return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
}
public function destroy($id)
{
    // Cari pelanggan berdasarkan ID
    $pelanggan = Pelanggan::findOrFail($id);

    // Hapus pelanggan
    $pelanggan->delete();

    // Redirect ke halaman dashboard pelanggan dengan pesan sukses
    return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
}
}