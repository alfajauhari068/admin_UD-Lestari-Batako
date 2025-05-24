<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function index()
    {
        $detailpesanan = DetailPesanan::with('produk')->get();
        return view('pesanan.detail_pesanan', compact('detailpesanan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pesanan' => 'required|exists:pesanans,id_pesanan',
            'id_produk' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        DetailPesanan::create($validatedData);

        return redirect()->route('detailpesanan.index')->with('success', 'Detail pesanan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_pesanan' => 'required|exists:pesanans,id_pesanan',
            'id_produk' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        $detailpesanan = DetailPesanan::findOrFail($id);
        $detailpesanan->update($validatedData);

        return redirect()->route('detailpesanan.index')->with('success', 'Detail pesanan berhasil diupdate');
    }

    public function destroy($id)
    {
        $detailpesanan = DetailPesanan::findOrFail($id);
        $detailpesanan->delete();

        return redirect()->route('detailpesanan.index')->with('success', 'Detail pesanan berhasil dihapus');
    }
}
