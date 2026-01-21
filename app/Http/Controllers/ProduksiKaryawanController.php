<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Produksi;
use App\Models\ProduksiKaryawanTim;
use App\Services\GajiTimService;
use Illuminate\Http\Request;

class ProduksiKaryawanController extends Controller
{

    public function index(Request $request)
    {
        // This dashboard is per-karyawan. Accept nullable id_karyawan to avoid hard validation errors
        $validated = $request->validate([
            'id_karyawan' => 'nullable|exists:karyawans,id_karyawan',
            'id_produksi' => 'nullable|exists:produksis,id_produksi',
            'tanggal_produksi' => 'nullable|date',
        ]);

        $idKaryawan = $validated['id_karyawan'] ?? null;

        if (empty($idKaryawan)) {
            // Do not throw validation exception — show empty result and ask user to pick a karyawan
            $produksiKaryawans = collect();
            return view('karyawan_produksi.dashboard_produksi_karyawan', compact('produksiKaryawans'))->withErrors(['id_karyawan' => 'Silakan pilih karyawan.']);
        }

        $query = \DB::table('produksi_karyawan_tim as pkt')
            ->join('produksis as p', 'pkt.id_produksi', '=', 'p.id_produksi')
            ->leftJoin('produks as prod', 'p.id_produk', '=', 'prod.id_produk')
            ->where('pkt.id_karyawan', $idKaryawan)
            ->select(
                'pkt.id_produksi',
                'prod.nama_produk as nama_produksi',
                \DB::raw('DATE(pkt.tanggal_produksi) as tanggal_produksi'),
                \DB::raw('SUM(pkt.jumlah_unit) as jumlah_unit')
            )
            ->groupBy('pkt.id_produksi', \DB::raw('DATE(pkt.tanggal_produksi)'), 'prod.nama_produk')
            ->orderByDesc('tanggal_produksi');

        if (!empty($validated['id_produksi'])) {
            $query->where('pkt.id_produksi', $validated['id_produksi']);
        }
        if (!empty($validated['tanggal_produksi'])) {
            $query->whereDate('pkt.tanggal_produksi', $validated['tanggal_produksi']);
        }

        $rows = $query->get();

        $service = new GajiTimService();

        // For each contribution row of this karyawan, call service to get per-karyawan wage
        $produksiKaryawans = $rows->map(function ($r) use ($service) {
            $tanggal = $r->tanggal_produksi;
            try {
                $gaji = $service->hitungGajiTim($r->id_produksi, $tanggal);
                $gaji_per_karyawan = $gaji['upah_per_karyawan'];
                $status = 'ok';
            } catch (\Exception $e) {
                $gaji_per_karyawan = null; // indicate not computed or invalid
                $status = 'not_computed';
            }

            return (object) [
                'id_produksi' => $r->id_produksi,
                'produksi' => (object) ['id_produksi' => $r->id_produksi, 'nama_produksi' => $r->nama_produksi],
                'tanggal_produksi' => $tanggal,
                'jumlah_unit' => (int) $r->jumlah_unit,
                'gaji_diterima' => $gaji_per_karyawan,
                'status' => $status,
            ];
        });

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
            'karyawan_ids' => 'required|array|min:1',
        ]);

        // Hitung total upah keseluruhan untuk tim menggunakan numeric `gaji_per_unit`
        $produksi = Produksi::findOrFail($validatedData['id_produksi']);
        $gajiPerUnit = is_numeric($produksi->gaji_per_unit) ? (float) $produksi->gaji_per_unit : 0;
        $upahTotalKeseluruhan = $validatedData['jumlah_unit'] * $gajiPerUnit;

        // Kalkulasi upah per unit (jika jumlah_unit > 0)
        $perUnitPay = $gajiPerUnit;

        // Distribusikan jumlah unit ke setiap karyawan secara merata
        $karyawanIds = $validatedData['karyawan_ids'];
        $count = count($karyawanIds);
        $totalUnits = (int) $validatedData['jumlah_unit'];
        $base = intdiv($totalUnits, $count);
        $remainder = $totalUnits % $count;

        foreach ($karyawanIds as $index => $karyawanId) {
            $assignedUnits = $base + ($index < $remainder ? 1 : 0);

            ProduksiKaryawanTim::create([
                'id_produksi' => $validatedData['id_produksi'],
                'id_karyawan' => $karyawanId,
                'tanggal_produksi' => $validatedData['tanggal_produksi'],
                'jumlah_unit' => $assignedUnits,
            ]);
        }

        return redirect()->route('karyawan_produksi.index')->with('success', 'Data produksi karyawan berhasil ditambahkan.');
    }


    public function detail($id, $tanggal)
    {
        // Treat $id as id_produksi and $tanggal as the production date (YYYY-MM-DD)
        $produksi = Produksi::findOrFail($id);

        // Load only member rows for that produksi on the given date
        $members = ProduksiKaryawanTim::with('karyawan')
            ->where('id_produksi', $id)
            ->whereDate('tanggal_produksi', $tanggal)
            ->get();

        // Use GajiTimService to compute team payroll for that date
        $service = new GajiTimService();
        $gaji = $service->hitungGajiTim($id, $tanggal);

        $total_unit = $gaji['total_unit_tim'];
        $total_upah = $gaji['total_upah_tim'];
        $upah_per_karyawan = $gaji['upah_per_karyawan'];

        // Build an object compatible with the existing view and include totals
        $produksiKaryawan = (object) [
            'produksi' => $produksi,
            'tim' => $members,
            'upah_total' => $total_upah,
            'total_unit' => $total_unit,
            'total_upah' => $total_upah,
            'upah_per_karyawan' => $upah_per_karyawan,
            'tanggal_produksi' => $tanggal,
        ];

        return view('karyawan_produksi.detail_karyawan_produksi', compact('produksiKaryawan', 'total_unit', 'total_upah'));
    }

    public function edit($id)
    {
        $produksiKaryawan = ProduksiKaryawanTim::with(['karyawan', 'produksi'])->findOrFail($id);
        $karyawans = Karyawan::all();
        $produksis = Produksi::all();
        return view('karyawan_produksi.edit_produksi_karyawan', compact('produksiKaryawan', 'karyawans', 'produksis'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_produksi' => 'required|exists:produksis,id_produksi',
            'tanggal_produksi' => 'required|date',
            'jumlah_unit' => 'required|integer|min:1',
        ]);

        $produksiKaryawan = ProduksiKaryawanTim::findOrFail($id);
        $produksi = Produksi::findOrFail($validatedData['id_produksi']);
        $gajiPerUnit = is_numeric($produksi->gaji_per_unit) ? (float) $produksi->gaji_per_unit : 0;

        $produksiKaryawan->update([
            'id_produksi' => $validatedData['id_produksi'],
            'tanggal_produksi' => $validatedData['tanggal_produksi'],
            'jumlah_unit' => $validatedData['jumlah_unit'],
        ]);

        return redirect()->route('karyawan_produksi.index')->with('success', 'Data produksi karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produksiKaryawan = ProduksiKaryawanTim::findOrFail($id);
        $produksiKaryawan->delete();
        return redirect()->route('karyawan_produksi.index')->with('success', 'Data produksi karyawan berhasil dihapus.');
    }
}
