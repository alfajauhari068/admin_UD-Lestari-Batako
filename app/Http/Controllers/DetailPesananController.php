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

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'create', 'show']);
        // TODO: middleware not registered, removed for safety
    }
    public function create($id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);
        $produks = Produk::where('stok_tersedia', '>', 0)->get();
        return view('pesanan.add_detail_pesanan', compact('pesanan', 'produks'));
    }

    public function show($id_detail_pesanan)
    {
        $detail = DetailPesanan::with('pesanan')->findOrFail($id_detail_pesanan);
        // Redirect to the parent pesanan detail page (no dedicated show view for detail)
        return redirect()->route('pesanan.detail', $detail->id_pesanan);
    }

    public function store(Request $request)
    {
        // Support single or multiple products submitted as arrays
        $validatedData = $request->validate([
            'id_pesanan' => 'required|exists:pesanans,id_pesanan',
            'id_produk' => 'required',
            'id_produk.*' => 'exists:produks,id_produk',
            'jumlah' => 'required',
            'jumlah.*' => 'integer|min:1',
        ]);

        $id_pesanan = $validatedData['id_pesanan'];

        $ids = is_array($request->input('id_produk')) ? $request->input('id_produk') : [$request->input('id_produk')];
        $jumlahs = is_array($request->input('jumlah')) ? $request->input('jumlah') : [$request->input('jumlah')];

        // Pre-transaction validation: batch-load produk to avoid per-item queries
        $produkMap = Produk::whereIn('id_produk', $ids)->get()->keyBy('id_produk');
        $errors = [];
        foreach ($ids as $index => $id_produk) {
            $jumlah = isset($jumlahs[$index]) ? (int) $jumlahs[$index] : 0;
            $produk = $produkMap->get($id_produk);
            if (!$produk) {
                $errors["id_produk.$index"] = 'Produk tidak ditemukan.';
                continue;
            }
            if ($jumlah < 1) {
                $errors["jumlah.$index"] = 'Jumlah harus minimal 1.';
                continue;
            }
            if ($jumlah > $produk->stok_tersedia) {
                $errors["jumlah.$index"] = 'Jumlah melebihi stok tersedia untuk ' . $produk->nama_produk . ' (' . $produk->stok_tersedia . ').';
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->withErrors($errors);
        }

        try {
            DB::transaction(function () use ($ids, $jumlahs, $id_pesanan) {
                // Load fresh product models inside the transaction
                $produkList = Produk::whereIn('id_produk', $ids)->get()->keyBy('id_produk');
                foreach ($ids as $index => $id_produk) {
                    $jumlah = isset($jumlahs[$index]) ? (int) $jumlahs[$index] : 1;

                    $produk = $produkList->get($id_produk);
                    if (!$produk) {
                        throw new \Exception('Produk tidak ditemukan: ' . $id_produk);
                    }

                    // Reduce stock on Produk model; this will throw if insufficient
                    $produk->reduceStock($jumlah);

                    // Create detail record
                    DetailPesanan::create([
                        'id_pesanan' => $id_pesanan,
                        'id_produk' => $id_produk,
                        'jumlah' => $jumlah,
                        'total_bayar' => $produk->harga_satuan * $jumlah,
                    ]);
                }
            });

            return redirect()->route('pesanan.detail', $id_pesanan)->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            // If any exception (including insufficient stock), redirect back with error message
            return redirect()->back()->withInput()->withErrors(['stok' => $e->getMessage()]);
        }
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
