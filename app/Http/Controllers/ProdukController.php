<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\pesanan;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $DataBarang = Produk::all();
        return view('produk.dashboard_produk', ['KurirData' => $DataBarang]);
    }

   public function show($produk)
    {
        $DataBarang = Produk::find( $produk); // pakai $produk, bukan produk saja
        return view('produk.profil_produk', ['KurirData' => $DataBarang]);
    }

    public function create()
    {
        return view('produk.form_tambah_produk');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk'   => 'required|string|max:100',
            'harga_satuan'  => 'required|numeric|between:0,9999999999.99',
            'stok_tersedia' => 'required|integer|min:0',
        ]);

        Produk::create($validatedData);

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', "Produk {$validatedData['nama_produk']} berhasil ditambahkan.");
    }

    public function edit(Produk $produk)
    {
        return view('produk.form_edit_produk', ['produk' => $produk]);
    }

    public function update(Request $request, Produk $produk)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_produk'   => 'required|string|max:100',
            'harga_satuan'  => 'required|numeric|between:0,9999999999.99',
            'stok_tersedia' => 'required|integer|min:0',
        ]);

        // Update data produk
        $produk->update($validatedData);

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', "Update data {$validatedData['nama_produk']} berhasil");
    }

    public function delete($id)
    {
        $produk = Produk::findOrFail($id); // Cari produk berdasarkan ID
        $produk->delete(); // Hapus produk

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