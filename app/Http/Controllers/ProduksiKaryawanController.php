<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Produksi;
use App\Models\ProduksiKaryawan;
use App\Models\produksi_karyawan_tim;
use Illuminate\Http\Request;

class ProduksiKaryawanController extends Controller
{
    
    public function index(Request $request)
    {
        $produksiKaryawans = ProduksiKaryawan::with(['karyawan', 'produksi'])->get();
        return view('karyawan_produksi.dashboard_produksi_karyawan', compact('produksiKaryawans'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        $produksis = Produksi::all();
        return view('karyawan_produksi.create_produksi_karyawan', compact('karyawans', 'produksis'));
    }

    /**
     * Simpan data produksi karyawan
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_produksi' => 'required|exists:produksis,id_produksi',
            'tanggal_produksi' => 'required|date',
            'jumlah_unit' => 'required|integer|min:1',
            'karyawan_ids' => 'required|array|min:1', // Array ID karyawan
        ]);

        // Hitung total upah keseluruhan untuk tim
        $produksi = Produksi::findOrFail($validatedData['id_produksi']);
        $upahTotalKeseluruhan = ($validatedData['jumlah_unit'] / 400) * $produksi->kriteria_gaji;

        // Simpan data ke tabel produksi_karyawans
        $produksiKaryawan = ProduksiKaryawan::create([
            'id_produksi' => $validatedData['id_produksi'],
            'tanggal_produksi' => $validatedData['tanggal_produksi'],
            'jumlah_unit' => $validatedData['jumlah_unit'],
            'upah_total' => $upahTotalKeseluruhan,
        ]);

        // Simpan data ke tabel pivot produksi_karyawan_tim
        foreach ($validatedData['karyawan_ids'] as $karyawanId) {
            produksi_karyawan_tim::create([
                'id_produksi_karyawan' => $produksiKaryawan->id,
                'id_karyawan' => $karyawanId,
            ]);
        }

        return redirect()->route('karyawan_produksi.index')->with('success', 'Data produksi karyawan berhasil ditambahkan.');
    }

    /**
     * Ekspor laporan ke PDF
     */
    public function exportPdf(Request $request)
    {
        // Query data ProduksiKaryawan dengan relasi ke Karyawan dan Produksi
        $query = ProduksiKaryawan::with(['karyawan', 'produksi']);

        // Filter berdasarkan tanggal produksi jika ada
        if ($request->filled('tanggal')) {
            $query->whereHas('produksi', function ($q) use ($request) {
                $q->where('tanggal_produksi', $request->tanggal);
            });
        }

        // Filter berdasarkan karyawan jika ada
        if ($request->filled('karyawan_id')) {
            $query->where('id_karyawan', $request->karyawan_id);
        }

        // Ambil data yang sudah difilter
        $data = $query->orderByDesc('created_at')->get();

        // Generate PDF menggunakan library dompdf
        $pdf = \PDF::loadView('laporan.karyawan_produksi_pdf', compact('data'));

        return $pdf->download('laporan_upah_karyawan.pdf');
    }

    /**
     * Tampilkan detail produksi karyawan per tanggal
     */
    public function detail($id)
    {
        // Ambil data produksi berdasarkan ID
        $produksiKaryawan = ProduksiKaryawan::with(['produksi', 'tim.karyawan'])->findOrFail($id);

        // Hitung total jumlah unit dan upah keseluruhan
        $jumlahUnit = $produksiKaryawan->jumlah_unit;
        $upahTotalKeseluruhan = $produksiKaryawan->upah_total;

        return view('karyawan_produksi.detail_karyawan_produksi', compact('produksiKaryawan', 'jumlahUnit', 'upahTotalKeseluruhan'));
    }
}
