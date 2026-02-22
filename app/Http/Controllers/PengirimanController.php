<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of pengiriman
     */
    public function index()
    {
        $pengirimans = Pengiriman::with(['pesanan.pelanggan', 'pesanan.detailPesanan.produk'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengiriman.dashboard_pengiriman', compact('pengirimans'));
    }

    /**
     * Show the form for creating a new pengiriman
     */
    public function create()
    {
        // Ambil pesanan yang belum memiliki pengiriman atau statusnya bukan 'selesai'
        $pesanans = Pesanan::with(['pelanggan', 'detailPesanan.produk'])
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->get();

        return view('pengiriman.create', compact('pesanans'));
    }

    /**
     * Store a newly created pengiriman
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pesanan' => 'required|exists:pesanans,id_pesanan',
            'alamat_pengiriman' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'tanggal_pengiriman' => 'required|date',
            'jenis_pengiriman' => 'required|in:Internal / Ambil Sendiri,Kurir Lokal,Ekspedisi',
            'status' => 'required|in:Menunggu Dijadwalkan,Dalam Pengiriman,Terkirim,Dibatalkan',
            'catatan' => 'nullable|string',
        ]);

        // Ambil id_pelanggan dari pesanan
        $pesanan = Pesanan::findOrFail($validatedData['id_pesanan']);
        $validatedData['id_pelanggan'] = $pesanan->id_pelanggan;

        // Buat pengiriman
        $pengiriman = Pengiriman::create($validatedData);

        // Update status pesanan jika pengiriman terkirim
        if ($validatedData['status'] === 'Terkirim') {
            $pesanan->update(['status' => 'selesai']);
        }

        return redirect()->route('pengiriman.index')
            ->with('success', 'Pengiriman berhasil dibuat.');
    }

    /**
     * Display the specified pengiriman
     */
    public function show($id_pengiriman)
    {
        $pengiriman = Pengiriman::with(['pesanan.pelanggan', 'pesanan.detailPesanan.produk'])
            ->findOrFail($id_pengiriman);

        return view('pengiriman.detail_pengiriman', compact('pengiriman'));
    }

    /**
     * Show the form for editing the specified pengiriman
     */
    public function edit($id)
    {
        $pengiriman = Pengiriman::with(['pesanan.pelanggan', 'pesanan.detailPesanan.produk'])
            ->findOrFail($id);

        $pesanans = Pesanan::with(['pelanggan', 'detailPesanan.produk'])
            ->whereNotIn('status', ['dibatalkan'])
            ->get();

        return view('pengiriman.edit', compact('pengiriman', 'pesanans'));
    }

    /**
     * Update the specified pengiriman
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'alamat_pengiriman' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'tanggal_pengiriman' => 'required|date',
            'jenis_pengiriman' => 'required|in:Internal / Ambil Sendiri,Kurir Lokal,Ekspedisi',
            'status' => 'required|in:Menunggu Dijadwalkan,Dalam Pengiriman,Terkirim,Dibatalkan',
            'catatan' => 'nullable|string',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $oldStatus = $pengiriman->status;

        $pengiriman->update($validatedData);

        // Update status pesanan jika status berubah menjadi Terkirim
        if ($oldStatus !== 'Terkirim' && $validatedData['status'] === 'Terkirim') {
            $pengiriman->pesanan->update(['status' => 'selesai']);
        }

        return redirect()->route('pengiriman.index')
            ->with('success', 'Pengiriman berhasil diperbarui.');
    }

    /**
     * Remove the specified pengiriman
     */
    public function destroy($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->delete();

        return redirect()->route('pengiriman.index')
            ->with('success', 'Pengiriman berhasil dihapus.');
    }

    /**
     * API endpoint untuk mendapatkan detail pesanan
     */
    public function getPesananDetail($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.produk'])
            ->findOrFail($id);

        // Format detail produk
        $produkList = $pesanan->detailPesanan->map(function ($detail) {
            return [
                'nama' => $detail->produk->nama ?? 'N/A',
                'jumlah' => $detail->jumlah,
                'satuan' => $detail->produk->satuan ?? 'pcs',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'pelanggan' => [
                    'nama' => $pesanan->pelanggan->nama ?? 'N/A',
                    'no_hp' => $pesanan->pelanggan->no_hp ?? 'N/A',
                    'alamat' => $pesanan->pelanggan->alamat ?? 'N/A',
                ],
                'produk' => $produkList,
                'total_bayar' => $pesanan->total_bayar,
            ]
        ]);
    }
}
