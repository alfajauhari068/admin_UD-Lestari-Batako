<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPesananController extends Controller
{
    public function index()
    {
        
        $detailpesanans = DetailPesanan::with('pesanan.pelanggan')->get();

        
        return view('pesanan.detail_pesanan', compact('detailpesanans'));
    }
    public function create($id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);
        $produks = Produk::all(); // Ambil semua produk untuk dropdown
        return view('pesanan.create_detail_pesanan', compact('pesanan', 'produks'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pesanan' => 'required|exists:pesanans,id_pesanan',
            'id_produk' => 'required|exists:produks,id_produk', 
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::where('id_produk', $validatedData['id_produk'])->firstOrFail(); // Gunakan kolom yang benar

        DetailPesanan::create([
            'id_pesanan' => $validatedData['id_pesanan'],
            'id_produk' => $validatedData['id_produk'],
            'jumlah' => $validatedData['jumlah'],
            'total_bayar' => $produk->harga_satuan * $validatedData['jumlah'],
        ]);

        return redirect()->route('pesanan.detail', $validatedData['id_pesanan'])->with('success', 'Produk berhasil ditambahkan.');
    }
    public function edit($id)
    {
        
        $detailPesanan = DetailPesanan::with('produk')->findOrFail($id);

    
        $produks = Produk::all();

        
        return view('pesanan.edit_detail_pesanan', compact('detailPesanan', 'produks'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_produk' => 'required|exists:produks,id_produk', 
            'jumlah' => 'required|integer|min:1',
        ]);

        $detailPesanan = DetailPesanan::findOrFail($id);
        $produk = Produk::where('id_produk', $validatedData['id_produk'])->firstOrFail(); 

        $detailPesanan->update([
            'id_produk' => $validatedData['id_produk'],
            'jumlah' => $validatedData['jumlah'],
            'total_bayar' => $produk->harga_satuan * $validatedData['jumlah'],
        ]);

        return redirect()->route('pesanan.detail', $detailPesanan->id_pesanan)->with('success', 'Detail pesanan berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $detailPesanan = DetailPesanan::findOrFail($id);
        $detailPesanan->delete();

        return redirect()->route('pesanan.detail', $detailPesanan->id_pesanan)->with('success', 'Produk berhasil dihapus.');
    }

}
