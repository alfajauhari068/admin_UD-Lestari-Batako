<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $DataBarang = Produk::all();
        return view('produk.dashboard_produk', ['KurirData' => $DataBarang]);
    }

   public function show($id_produk)
    {
        $DataBarang = Produk::find( $id_produk);
        return view('produk.profil_produk',['KurirData' => $DataBarang]);
    }

    public function create()
    {
        return view('produk.form_tambah_produk');
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'harga_satuan' => 'required|numeric|min:0',
            'stok_tersedia' => 'required|integer|min:0',
            'deskripsi_produk' => 'nullable|string|max:1000', // Validasi deskripsi
        ]);

        if ($request->hasFile('gambar_produk')) {
            $validatedData['gambar_produk'] = $request->file('gambar_produk')->store('gambar_produk', 'public');
        }

        Produk::create($validatedData);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

public function edit($id)
{
    $produk = Produk::findOrFail($id); // Pastikan produk ditemukan
    return view('produk.form_edit_produk', ['produk' => $produk]);
}

public function update(Request $request, $id)
{
    $produk = Produk::findOrFail($id); // Pastikan produk ditemukan

    // Validasi input
    $validatedData = $request->validate([
        'nama_produk'   => 'required|string|max:255',
        'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'harga_satuan'  => 'required|numeric|min:0',
        'stok_tersedia' => 'required|integer|min:0',
        'deskripsi_produk' => 'nullable|string|max:1000', // Validasi deskripsi
    ]);

    // Jika ada file gambar baru, hapus gambar lama dan simpan gambar baru
    if ($request->hasFile('gambar_produk')) {
        // Hapus gambar lama jika ada
        if ($produk->gambar_produk && file_exists(public_path('gambar_produk/' . $produk->gambar_produk))) {
            unlink(public_path('gambar_produk/' . $produk->gambar_produk));
        }

        // Simpan gambar baru
        $validatedData['gambar_produk'] = $request->file('gambar_produk')->store('gambar_produk', 'public');
    }

    // Update data produk
    $produk->update($validatedData);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
}


    public function delete($id)
    {
        $produk = Produk::findOrFail($id);

        return redirect()->route('produk.index')->with('pesan', "Hapus data $produk->nama_produk berhasil");
    }

    public function getRouteKeyName()
    {
        return 'id_produk';
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}