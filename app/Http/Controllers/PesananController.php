<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('pelanggan')->get(); // Ambil data pesanan beserta relasi pelanggan
        return view('pesanan.dashboard_pesanan', compact('pesanans'));
    }


    public function create()
    {
        
        $pelanggans = Pelanggan::all(); // Pastikan model Pelanggan sudah benar

        
        return view('pesanan.form_tambah_pesanan', compact('pelanggans'));
    }
   public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan', // Relasi ke tabel pelanggans
            'catatan' => 'nullable|string',
        ]);

        
        Pesanan::create([
            'id_pelanggan' => $validatedData['id_pelanggan'],
            'catatan' => $validatedData['catatan'],
        ]);

        
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function show($id)
    {
        
        $pesanan = Pesanan::with(['detailPesanan.produk', 'pelanggan'])->findOrFail($id);

        
        return view('pesanan.detail_pesanan', compact('pesanan'));
    }

    public function edit($id)
    {
        $pesanan = Pesanan::with('detailPesanan')->findOrFail($id);
        $produks = Produk::all();
        return view('pesanan.edit', compact('pesanan', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable',
            'id_produk' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['catatan' => $request->catatan]);

        $pesanan->detailPesanan()->delete();
        $total = 0;

        foreach ($request->id_produk as $i => $id_produk) {
            $produk = Produk::find($id_produk);
            $jumlah = $request->jumlah[$i];
            $subtotal = $produk->harga_satuan * $jumlah;

            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk' => $id_produk,
                'jumlah' => $jumlah,
                'total_bayar' => $subtotal,
            ]);

            $total += $subtotal;
        }

        $pesanan->update(['total_bayar' => $total]);

        return redirect()->route('pesanan.index');
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();
        return redirect()->route('pesanan.index');
    }

    public function createDetailPesanan($id_pesanan)
    {
        $produks = Produk::all();
        return view('pesanan.tambah_detail_pesanan', compact('id_pesanan', 'produks'));
    }

    public function detail($id_pesanan)
    {
        $pesanan = Pesanan::with('pelanggan')->findOrFail($id_pesanan);
        return view('pesanan.detail_pesanan', compact('pesanan'));
    }

    

    
}
