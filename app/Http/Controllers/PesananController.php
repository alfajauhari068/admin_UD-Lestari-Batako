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

    public function __construct()
    {
        // Require authentication for mutation routes
        $this->middleware('auth')->except(['index', 'show', 'detail', 'create', 'createDetailPesanan']);

        // Apply Spatie permission middleware when available (non-fatal if not installed)
        if (class_exists(\Spatie\Permission\Models\Permission::class)) {
            $this->middleware('permission:create pesanan')->only(['create', 'store']);
            $this->middleware('permission:export pesanan')->only(['exportCsv']);
            $this->middleware('permission:edit pesanan')->only(['edit', 'update']);
            $this->middleware('permission:delete pesanan')->only(['destroy']);
        }
    }

    /**
     * Export pesanan as CSV (permission: export pesanan)
     */
    public function exportCsv()
    {
        $user = auth()->user();
        if (!$user || !$user->can('export pesanan')) {
            abort(403);
        }

        $pesanans = Pesanan::with('pelanggan')->get();
        $filename = 'pesanan_export_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($pesanans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id_pesanan', 'id_pelanggan', 'pelanggan_nama', 'catatan', 'created_at']);
            foreach ($pesanans as $p) {
                fputcsv($handle, [$p->id_pesanan, $p->id_pelanggan, optional($p->pelanggan)->nama, strip_tags($p->catatan ?? ''), optional($p->created_at)->toDateTimeString()]);
            }
            fclose($handle);
        };

        return \Illuminate\Support\Facades\Response::stream($callback, 200, $headers);
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

            // Batch-load produk to avoid per-item queries
            $produkMap = Produk::whereIn('id_produk', $ids)->get()->keyBy('id_produk');

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

                    // Load fresh product models inside transaction to ensure correct stock
                    $produkList = Produk::whereIn('id_produk', $ids)->get()->keyBy('id_produk');

                    foreach ($ids as $index => $id_produk) {
                        $jumlah = isset($jumlahs[$index]) ? (int) $jumlahs[$index] : 1;
                        $produk = $produkList->get($id_produk);
                        if (!$produk) {
                            throw new \Exception('Produk tidak ditemukan: ' . $id_produk);
                        }

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

        // Batch-load produk referenced in the update to avoid N+1 queries
        $ids = is_array($request->id_produk) ? $request->id_produk : [$request->id_produk];
        $produkMap = Produk::whereIn('id_produk', $ids)->get()->keyBy('id_produk');

        foreach ($request->id_produk as $i => $id_produk) {
            $produk = $produkMap->get($id_produk);
            if (!$produk) {
                continue; // skip missing product (validation should prevent this)
            }
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
