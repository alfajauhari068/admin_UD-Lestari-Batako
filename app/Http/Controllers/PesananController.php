<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PesananController extends Controller
{

    public function index()
    {
        // Ambil semua data pesanan beserta relasi pelanggan
        $pesanans = Pesanan::with('pelanggan')->get();

        // Tampilkan view untuk daftar pesanan
        return view('pesanan.dashboard_pesanan', compact('pesanans'));
    }

    public function show($id)
    {
        // Ambil data pesanan beserta relasi pelanggan dan detail pesanan
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.produk'])->findOrFail($id);

        // Kirim data ke view
        return view('pesanan.detail_pesanan', compact('pesanan'));
    }

    public function create($id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan); // Ambil data pelanggan berdasarkan ID
        $produks = Produk::all();
        return view('pesanan.form_tambah_pesanan', compact('pelanggan', 'produks'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'id' => 'required|array', // Menggunakan 'id' sesuai dengan nama kolom di tabel produk
            'id.*' => 'exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        if (count($request->id) !== count($request->jumlah)) {
            return back()->withErrors(['jumlah' => 'Jumlah produk dan jumlah pesanan tidak sesuai.']);
        }

        // Simpan pesanan utama terlebih dahulu
    $pesanan = Pesanan::create([
    'id_pelanggan' => $request->id_pelanggan,
    'catatan' => $request->catatan,
    'total_bayar' => 0,
    'status' => 'Diproses',
]);

$total_bayar = 0;

foreach ($request->id as $index => $id) {
    $produk = Produk::findOrFail($id);
    $jumlah = $request->jumlah[$index];
    $total_harga = $produk->harga_satuan * $jumlah;
    $total_bayar += $total_harga; // ← tambahkan ke total_bayar

        DetailPesanan::create([
        'id_pesanan' => $pesanan->id_pesanan,
        'id_produk' => $id, // ✅ pakai nama kolom baru
        'jumlah' => $jumlah,
        'total_bayar' => $total_bayar,
    ]);
}

        // $total_bayar = 0;

        // foreach ($request->id as $index => $id) {
        //     $produk = Produk::findOrFail($id); // Cari produk berdasarkan ID
        //     $jumlah = $request->jumlah[$index];
        //     $total_harga = $produk->harga_satuan * $jumlah;
        //     $total_bayar += $total_harga;

        //     // Simpan detail pesanan
        //     DetailPesanan::create([
        //         'id_pesanan' => $pesanan->id_pesanan,
        //         'id' => $id, // ID produk
        //         'jumlah' => $jumlah,
        //         'total_bayar' => $total_bayar, // Ganti total_harga menjadi total_bayar
        //     ]);
        // }

        // Update total bayar di pesanan utama
        $pesanan->update(['total_bayar' => $total_bayar]);

        return redirect()->route('pesanan.exportPdf', $pesanan->id_pesanan);
    }

    public function exportPdf($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.produk'])->findOrFail($id);

        $pdf = Pdf::loadView('pesanan.detail_pesanan_pdf', compact('pesanan'));
        return $pdf->download('detail_pesanan_' . $pesanan->id_pesanan . '.pdf');
    }

    public function edit($id)
    {
        // Ambil data pesanan beserta detail dan produk terkait
        $pesanan = Pesanan::with('detailPesanan.produk', 'pelanggan')->findOrFail($id);

        // Ambil semua produk untuk dropdown
        $produks = Produk::all();

        // Kirim data ke view
        return view('pesanan.edit_pesanan', compact('pesanan', 'produks'));
    }
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'nama_pelanggan' => 'required|string|max:255',
        'catatan' => 'nullable|string',
        'id' => 'required|array',
        'id.*' => 'exists:produks,id',
        'jumlah' => 'required|array',
        'jumlah.*' => 'integer|min:1',
    ]);

    $pesanan = Pesanan::findOrFail($id);

    // Update nama pelanggan
    $pesanan->pelanggan->update(['nama' => $request->nama_pelanggan]);

    // Update catatan pesanan
    $pesanan->update(['catatan' => $request->catatan]);

    // Hapus detail pesanan lama
    $pesanan->detailPesanan()->delete();

    $total_bayar = 0;

    // Simpan detail pesanan baru
    foreach ($request->id as $index => $id_produk) {
        $produk = Produk::findOrFail($id_produk);
        $jumlah = $request->jumlah[$index];
        $total_harga = $produk->harga_satuan * $jumlah;
        $total_bayar += $total_harga;

        DetailPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_produk' => $id_produk,
            'jumlah' => $jumlah,
            'total_bayar' => $total_harga,
        ]);
    }

    // Update total bayar di pesanan utama
    $pesanan->update(['total_bayar' => $total_bayar]);

    return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui.');
}
}
