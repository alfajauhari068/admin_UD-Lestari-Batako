<?php

namespace App\Http\Controllers;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        
        $pengirimans = Pengiriman::with('pesanan.pelanggan')->get();

        
        return view('pengiriman.dashboard_pengiriman', compact('pengirimans'));
    }

    public function create($id_pesanan)
    {
        $pesanan = Pesanan::with('pelanggan')->findOrFail($id_pesanan);
        return view('pengiriman.create_pengiriman', compact('pesanan'));
    }

    public function store(Request $request)
{
    
    $validatedData = $request->validate([
        'id_pesanan' => 'required|exists:pesanans,id_pesanan',
        'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
        'alamat_pengiriman' => 'required|string|max:255',
        'tanggal_pengiriman' => 'required|date',
        'jasa_kurir' => 'required|string|max:100',
        'no_resi' => 'nullable|string|max:50',
    ]);

    Pengiriman::create($validatedData);

    
    return redirect()->route('pesanan.index')->with('success', 'Pengiriman berhasil diatur.');
}


    public function edit($id)
    {
        $pengiriman = Pengiriman::with('pesanan.pelanggan')->findOrFail($id);
        return view('pengiriman.edit_pengiriman', compact('pengiriman'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'alamat_pengiriman' => 'required|string|max:255',
            'tanggal_pengiriman' => 'nullable|date',
            'jasa_kurir' => 'nullable|string|max:100',
            'no_resi' => 'nullable|string|max:100',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->update($validatedData);

        return redirect()->route('pengiriman.index')->with('success', 'Pengiriman berhasil diperbarui.');
    }

    public function show($id_pengiriman)
    {
        $pengiriman = Pengiriman::with(['pesanan.pelanggan'])->findOrFail($id_pengiriman);
        return view('pengiriman.detail_pengiriman', compact('pengiriman'));
    }
    
public function destroy($id)
{
    $pengiriman = Pengiriman::findOrFail($id);
    $pengiriman->delete();

    return redirect()->route('pengiriman.index')->with('success', 'Pengiriman berhasil dihapus.');
}
}
