<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of MASTER ONGKOS (Produksi)
     * 
     * Ini adalah MASTER ONGKOS - bukan transaksi harian
     * Setiap record menentukan upah per unit untuk produk tertentu
     */
    public function index()
    {
        $produksis = Produksi::with('produk')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('produksi.index', compact('produksis'));
    }

    /**
     * Show the form for creating new MASTER ONGKOS
     */
    public function create()
    {
        $produks = Produk::all();

        return view('produksi.create', compact('produks'));
    }

    /**
     * Store newly created MASTER ONGKOS
     * 
     * Hanya menyimpan: id_produk, upah_per_unit, satuan, keterangan
     * TIDAK ada tanggal, karyawan, atau jumlah_produksi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'upah_per_unit' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'id_produk.required' => 'Produk wajib dipilih',
            'id_produk.exists' => 'Produk tidak valid',
            'upah_per_unit.required' => 'Upah per unit wajib diisi',
            'upah_per_unit.numeric' => 'Upah harus berupa angka',
            'upah_per_unit.min' => 'Upah tidak boleh negatif',
            'satuan.required' => 'Satuan wajib diisi',
        ]);

        // Cek duplikasi: satu produk hanya boleh punya satu master ongkos
        $exists = Produksi::where('id_produk', $validated['id_produk'])->exists();
        if ($exists) {
            return back()->withErrors(['id_produk' => 'Master ongkos untuk produk ini sudah ada'])->withInput();
        }

        try {
            Produksi::create($validated);

            return redirect()->route('produksi.index')
                ->with('success', 'Master Ongkos berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display MASTER ONGKOS details
     * 
     * Menampilkan detail ongkos dan riwayat transaksi (jika ada)
     */
    public function show($id)
    {
        $produksi = Produksi::with('produk')->findOrFail($id);

        // Ambil riwayat transaksi jika ada
        $riwayatTransaksi = $produksi->timProduksi()
            ->with('karyawan')
            ->orderBy('tanggal_produksi', 'desc')
            ->limit(50)
            ->get();

        return view('produksi.show', compact('produksi', 'riwayatTransaksi'));
    }

    /**
     * Show the form for editing MASTER ONGKOS
     */
    public function edit($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produks = Produk::all();

        return view('produksi.edit', compact('produksi', 'produks'));
    }

    /**
     * Update MASTER ONGKOS
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'upah_per_unit' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Cek duplikasi (kecuali record ini)
        $exists = Produksi::where('id_produk', $validated['id_produk'])
            ->where('id_produksi', '!=', $id)
            ->exists();
        if ($exists) {
            return back()->withErrors(['id_produk' => 'Master ongkos untuk produk ini sudah ada'])->withInput();
        }

        $produksi = Produksi::findOrFail($id);
        $produksi->update($validated);

        return redirect()->route('produksi.show', $id)
            ->with('success', 'Master Ongkos berhasil diperbarui');
    }

    /**
     * Remove MASTER ONGKOS
     */
    public function destroy($id)
    {
        $produksi = Produksi::findOrFail($id);

        // Cek apakah ada transaksi yang menggunakan ongkos ini
        $hasTransactions = $produksi->timProduksi()->exists();
        if ($hasTransactions) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus - ada transaksi yang menggunakan ongkos ini']);
        }

        try {
            $produksi->delete();

            return redirect()->route('produksi.index')
                ->with('success', 'Master Ongkos berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus: ' . $e->getMessage()]);
        }
    }

    /**
     * Get informasi upah untuk produk (API)
     */
    public function getUpahInfo($id_produk)
    {
        $produksi = Produksi::where('id_produk', $id_produk)->first();

        if (!$produksi) {
            return response()->json([
                'success' => false,
                'message' => 'Master ongkos belum diatur untuk produk ini'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id_produksi' => $produksi->id_produksi,
                'id_produk' => $produksi->id_produk,
                'nama_produk' => $produksi->produk->nama_produk ?? 'N/A',
                'upah_per_unit' => $produksi->upah_per_unit,
                'satuan' => $produksi->satuan,
            ]
        ]);
    }
}
