<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
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
            // Optional: allow creating pesanan with detail items in same request
            'id_produk' => 'sometimes',
            'id_produk.*' => 'exists:produks,id_produk',
            'jumlah' => 'sometimes',
            'jumlah.*' => 'integer|min:1',
        ]);

        // If details provided, validate quantities against current stok before transaction
        $hasDetails = $request->has('id_produk');

        if ($hasDetails) {
            $ids = is_array($request->input('id_produk')) ? $request->input('id_produk') : [$request->input('id_produk')];
            $jumlahs = is_array($request->input('jumlah')) ? $request->input('jumlah') : [$request->input('jumlah')];
            $errors = [];

            foreach ($ids as $index => $id_produk) {
                $jumlah = isset($jumlahs[$index]) ? (int) $jumlahs[$index] : 0;
                $produk = Produk::where('id_produk', $id_produk)->first();
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
        }

        try {
            DB::transaction(function () use ($request, $validatedData, $hasDetails) {
                $pesanan = Pesanan::create([
                    'id_pelanggan' => $validatedData['id_pelanggan'],
                    'catatan' => $validatedData['catatan'] ?? null,
                ]);

                if ($hasDetails) {
                    $ids = is_array($request->input('id_produk')) ? $request->input('id_produk') : [$request->input('id_produk')];
                    $jumlahs = is_array($request->input('jumlah')) ? $request->input('jumlah') : [$request->input('jumlah')];

                    foreach ($ids as $index => $id_produk) {
                        $jumlah = isset($jumlahs[$index]) ? (int) $jumlahs[$index] : 1;
                        $produk = Produk::where('id_produk', $id_produk)->firstOrFail();

                        // reduceStock will throw if insufficient
                        $produk->reduceStock($jumlah);

                        DetailPesanan::create([
                            'id_pesanan' => $pesanan->id_pesanan,
                            'id_produk' => $id_produk,
                            'jumlah' => $jumlah,
                            'total_bayar' => $produk->harga_satuan * $jumlah,
                        ]);
                    }
                }
            });

            return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['pesanan' => $e->getMessage()]);
        }
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
        // Eager load detailPesanan->produk so view can access $item->produk
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.produk'])->findOrFail($id_pesanan);
        return view('pesanan.detail_pesanan', compact('pesanan'));
    }




}
