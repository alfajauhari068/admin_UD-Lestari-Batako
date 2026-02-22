<?php

namespace App\Http\Controllers;

use App\Models\TimProduksi;
use App\Models\Produksi;
use App\Models\Produk;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimProduksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of TRANSAKSI HARIAN (TimProduksi)
     * 
     * Ini adalah TRANSAKSI HARIAN - mencatat produksi karyawan per hari
     */
    public function index(Request $request)
    {
        $query = TimProduksi::with(['karyawan', 'produksi.produk']);

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->byTanggal($request->tanggal);
        }

        // Filter range tanggal
        if ($request->filled('dari_tanggal') && $request->filled('sampai_tanggal')) {
            $query->whereBetween('tanggal_produksi', [$request->dari_tanggal, $request->sampai_tanggal]);
        }

        // Filter karyawan
        if ($request->filled('karyawan_id')) {
            $query->forKaryawan($request->karyawan_id);
        }

        // Filter master ongkos
        if ($request->filled('produksi_id')) {
            $query->forProduksi($request->produksi_id);
        }

        $transaksis = $query->orderBy('tanggal_produksi', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);

        // Untuk filter
        $karyawans = Karyawan::all();
        $produksis = Produksi::with('produk')->get();

        return view('tim_produksi.index', compact('transaksis', 'karyawans', 'produksis'));
    }

    /**
     * Show the form for creating new TRANSAKSI HARIAN
     */
    public function create()
    {
        $karyawans = Karyawan::all();
        $produksis = Produksi::with('produk')->get();

        return view('tim_produksi.create', compact('karyawans', 'produksis'));
    }

    /**
     * Store newly created TRANSAKSI HARIAN
     * 
     * CRITICAL: Snapshot upah_per_unit dari master ongkos
     * total_upah akan dihitung otomatis oleh model
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_produksi' => 'required|exists:produksis,id_produksi',
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'tanggal_produksi' => 'required|date',
            'jumlah_produksi' => 'required|integer|min:1',
        ], [
            'id_produksi.required' => 'Master Ongkos wajib dipilih',
            'id_karyawan.required' => 'Karyawan wajib dipilih',
            'tanggal_produksi.required' => 'Tanggal produksi wajib diisi',
            'jumlah_produksi.required' => 'Jumlah produksi wajib diisi',
            'jumlah_produksi.min' => 'Jumlah produksi minimal 1',
        ]);

        // Ambil master ongkos untuk snapshot
        $masterOngkos = Produksi::with('produk')->findOrFail($validated['id_produksi']);

        // Cek apakah produk_id ada di master ongkos
        $produkId = $masterOngkos->produk_id;

        // Validasi duplikasi: karyawan + master ongkos + tanggal
        $exists = TimProduksi::where('id_produksi', $validated['id_produksi'])
            ->where('id_karyawan', $validated['id_karyawan'])
            ->whereDate('tanggal_produksi', $validated['tanggal_produksi'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'id_karyawan' => 'Transaksi untuk karyawan ini pada tanggal tersebut sudah ada'
            ])->withInput();
        }

        try {
            TimProduksi::create([
                'id_produksi' => $validated['id_produksi'],
                'produk_id' => $produkId,
                'id_karyawan' => $validated['id_karyawan'],
                'tanggal_produksi' => $validated['tanggal_produksi'],
                'jumlah_produksi' => $validated['jumlah_produksi'],
                'upah_per_unit' => $masterOngkos->upah_per_unit, // SNAPSHOT!
            ]);

            // total_upah akan dihitung otomatis oleh model boot method

            return redirect()->route('tim-produksi.index')
                ->with('success', 'Transaksi produksi berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display TRANSAKSI HARIAN details
     */
    public function show(string $id)
    {
        $transaksi = TimProduksi::with(['karyawan', 'produksi.produk', 'produk'])
            ->findOrFail($id);

        return view('tim_produksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing TRANSAKSI HARIAN
     */
    public function edit(string $id)
    {
        $transaksi = TimProduksi::findOrFail($id);
        $karyawans = Karyawan::all();
        $produksis = Produksi::with('produk')->get();

        return view('tim_produksi.edit', compact('transaksi', 'karyawans', 'produksis'));
    }

    /**
     * Update TRANSAKSI HARIAN
     * 
     * Jika id_produksi berubah, harus update snapshot upah_per_unit
     */
    public function update(Request $request, string $id)
    {
        $transaksi = TimProduksi::findOrFail($id);

        $validated = $request->validate([
            'id_produksi' => 'required|exists:produksis,id_produksi',
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'tanggal_produksi' => 'required|date',
            'jumlah_produksi' => 'required|integer|min:1',
        ]);

        // Ambil master ongkos baru
        $masterOngkos = Produksi::with('produk')->findOrFail($validated['id_produksi']);

        // Validasi duplikasi (kecuali record ini)
        $exists = TimProduksi::where('id_produksi', $validated['id_produksi'])
            ->where('id_karyawan', $validated['id_karyawan'])
            ->whereDate('tanggal_produksi', $validated['tanggal_produksi'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'id_karyawan' => 'Transaksi untuk karyawan ini pada tanggal tersebut sudah ada'
            ])->withInput();
        }

        try {
            $transaksi->update([
                'id_produksi' => $validated['id_produksi'],
                'produk_id' => $masterOngkos->produk_id,
                'id_karyawan' => $validated['id_karyawan'],
                'tanggal_produksi' => $validated['tanggal_produksi'],
                'jumlah_produksi' => $validated['jumlah_produksi'],
                'upah_per_unit' => $masterOngkos->upah_per_unit, // Update snapshot
            ]);

            // total_upah akan dihitung ulang otomatis

            return redirect()->route('tim-produksi.show', $id)
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove TRANSAKSI HARIAN
     */
    public function destroy(string $id)
    {
        $transaksi = TimProduksi::findOrFail($id);

        try {
            $transaksi->delete();

            return redirect()->route('tim-produksi.index')
                ->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus: ' . $e->getMessage()]);
        }
    }

    /**
     * Get info for AJAX - when master ongkos is selected
     */
    public function getInfo($id_produksi)
    {
        $masterOngkos = Produksi::with('produk')->findOrFail($id_produksi);

        return response()->json([
            'success' => true,
            'data' => [
                'id_produksi' => $masterOngkos->id_produksi,
                'produk_id' => $masterOngkos->produk_id,
                'nama_produk' => $masterOngkos->produk->nama_produk ?? 'N/A',
                'upah_per_unit' => $masterOngkos->upah_per_unit,
                'satuan' => $masterOngkos->satuan,
            ]
        ]);
    }
}
