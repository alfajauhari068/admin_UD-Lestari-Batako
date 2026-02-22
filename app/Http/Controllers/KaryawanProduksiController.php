<?php
namespace App\Http\Controllers;

use App\Models\ProduksiKaryawanTim;
use App\Models\Karyawan;
use App\Models\Produksi;
use Illuminate\Http\Request;

class KaryawanProduksiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data produksi karyawan tim dengan relasi karyawan dan produksi
        $produksiKaryawans = ProduksiKaryawanTim::with(['karyawan', 'produksi'])->get();

        // Kirim data ke view
        return view('karyawan_produksi.dashboard_produksi_karyawan', compact('produksiKaryawans'));
    }

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'create']);
    }

    public function create()
    {
        // Ambil data karyawan dan produksi untuk form
        $karyawans = Karyawan::all();
        $produksis = Produksi::all();

        // Kirim data ke view
        return view('karyawan_produksi.create_produksi_karyawan', compact('karyawans', 'produksis'));
    }

    public function store(Request $request)
    {
        // Allow either a single id_karyawan or an array of karyawan_ids (team)
        $validated = $request->validate([
            'id_karyawan' => 'nullable|exists:karyawans,id_karyawan',
            'karyawan_ids' => 'nullable|array',
            'karyawan_ids.*' => 'exists:karyawans,id_karyawan',
            'id_produksi' => 'required|exists:produksis,id_produksi',
            'tanggal_produksi' => 'required|date',
            'jumlah_unit' => 'required|integer|min:1',
        ]);

        $karyawanList = [];
        if (!empty($validated['karyawan_ids']) && is_array($validated['karyawan_ids'])) {
            $karyawanList = $validated['karyawan_ids'];
        } elseif (!empty($validated['id_karyawan'])) {
            $karyawanList = [$validated['id_karyawan']];
        }

        if (empty($karyawanList)) {
            return redirect()->back()->withInput()->withErrors(['karyawan_ids' => 'Pilih setidaknya satu karyawan untuk tim produksi.']);
        }

        // Create a ProduksiKaryawan record for each selected karyawan.
        foreach ($karyawanList as $idKaryawan) {
            ProduksiKaryawanTim::create([
                'id_karyawan' => $idKaryawan,
                'id_produksi' => $validated['id_produksi'],
                'tanggal_produksi' => $validated['tanggal_produksi'],
                'jumlah_unit' => $validated['jumlah_unit'],
            ]);
        }

        return redirect()->route('karyawan_produksi.index')->with('success', 'Data produksi karyawan berhasil ditambahkan!');
    }

    public function edit($id_karyawan_produksi)
    {
        // Ambil data produksi karyawan tim berdasarkan ID
        $produksiKaryawan = ProduksiKaryawanTim::findOrFail($id_karyawan_produksi);

        // Ambil data karyawan dan produksi untuk form
        $karyawans = Karyawan::all();
        $produksis = Produksi::all();

        // Kirim data ke view
        return view('karyawan_produksi.edit_produksi_karyawan', compact('produksiKaryawan', 'karyawans', 'produksis'));
    }

    public function update(Request $request, $id_karyawan_produksi)
    {
        // Validasi data
        $validatedData = $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'id_produksi' => 'required|exists:produksis,id_produksi',
            'tanggal_produksi' => 'required|date',
            'jumlah_unit' => 'required|integer|min:1',
        ]);

        // Update data di database
        $produksiKaryawan = ProduksiKaryawanTim::findOrFail($id_karyawan_produksi);
        $produksiKaryawan->update($validatedData);

        // Redirect ke halaman dashboard dengan pesan sukses
        return redirect()->route('karyawan_produksi.index')->with('success', 'Data produksi karyawan berhasil diperbarui!');
    }

    public function destroy($id_karyawan_produksi)
    {
        // Hapus data produksi karyawan berdasarkan ID
        $produksiKaryawan = ProduksiKaryawanTim::findOrFail($id_karyawan_produksi);
        $produksiKaryawan->delete();

        // Redirect ke halaman dashboard dengan pesan sukses
        return redirect()->route('karyawan_produksi.index')->with('success', 'Data produksi karyawan berhasil dihapus!');
    }

    public function show($id_karyawan_produksi)
    {
        // Ambil data produksi karyawan tim berdasarkan ID dengan relasi
        $produksiKaryawan = ProduksiKaryawanTim::with(['karyawan', 'produksi.produk'])->findOrFail($id_karyawan_produksi);

        // Kirim data ke view
        return view('karyawan_produksi.detail_karyawan_produksi', compact('produksiKaryawan'));
    }
}