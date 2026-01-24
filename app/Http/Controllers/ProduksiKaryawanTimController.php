<?php

namespace App\Http\Controllers;

use App\Models\ProduksiKaryawanTim;
use App\Models\Produksi;
use App\Models\Karyawan;
use App\Services\GajiTimService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProduksiKaryawanTimController extends Controller
{
    protected GajiTimService $gajiTimService;

    public function __construct(GajiTimService $gajiTimService)
    {
        $this->gajiTimService = $gajiTimService;
        // Require auth for mutation routes; keep read routes public
        $this->middleware('auth')->except(['index', 'show', 'detail', 'detailByProduction', 'editByProduction']);

        if (class_exists(\Spatie\Permission\Models\Permission::class)) {
            $this->middleware('permission:create tim produksi')->only(['create', 'store']);
            $this->middleware('permission:edit tim produksi')->only(['edit', 'update', 'editByProduction']);
            $this->middleware('permission:delete tim produksi')->only(['destroy', 'destroyByProduction']);
        }
    }

    public function index()
    {
        // Ambil daftar kejadian produksi yang unik (grouped by id_produksi + tanggal_produksi)
        $distinct = ProduksiKaryawanTim::select('id_produksi', 'tanggal_produksi')
            ->distinct()
            ->get();

        // Preload Produksi models for the distinct produksi ids to avoid N+1
        $produksiIds = $distinct->pluck('id_produksi')->unique()->all();
        $produksiMap = Produksi::whereIn('id_produksi', $produksiIds)->get()->keyBy('id_produksi');

        $produksiKaryawanTims = $distinct->map(function ($g) use ($produksiMap) {
            $total_unit = ProduksiKaryawanTim::where('id_produksi', $g->id_produksi)
                ->whereDate('tanggal_produksi', $g->tanggal_produksi)
                ->sum('jumlah_unit');

            $produksi = $produksiMap->get($g->id_produksi);

            // Hitung gaji tim via service (pass produksi model to avoid extra lookup)
            try {
                $gaji = $this->gajiTimService->hitungGajiTim($g->id_produksi, Carbon::parse($g->tanggal_produksi)->format('Y-m-d'), $produksi);
                $total_gaji_tim = $gaji['total_upah_tim'] ?? 0;
                $jumlah_anggota = $gaji['jumlah_anggota'] ?? ProduksiKaryawanTim::where('id_produksi', $g->id_produksi)->whereDate('tanggal_produksi', $g->tanggal_produksi)->distinct('id_karyawan')->count('id_karyawan');
            } catch (Exception $e) {
                $total_gaji_tim = 0;
                $jumlah_anggota = ProduksiKaryawanTim::where('id_produksi', $g->id_produksi)->whereDate('tanggal_produksi', $g->tanggal_produksi)->distinct('id_karyawan')->count('id_karyawan');
            }

            return (object) [
                'id_produksi' => $g->id_produksi,
                'tanggal_produksi' => $g->tanggal_produksi,
                'produksi' => $produksi,
                'total_unit' => $total_unit,
                'jumlah_anggota' => $jumlah_anggota,
                'total_gaji_tim' => $total_gaji_tim,
            ];
        })->values();

        return view('produksi_karyawan_tim.dashboard_karyawan_tim', compact('produksiKaryawanTims'));
    }

    public function create()
    {
        // Ambil data produksi dan karyawan untuk form
        $produksis = Produksi::all();
        $karyawans = Karyawan::all();

        // Kirim data ke view
        return view('produksi_karyawan_tim.create', compact('produksis', 'karyawans'));
    }

    public function store(Request $request)
    {
        // Validasi data; support multiple karyawan via id_karyawan[]
        $validatedData = $request->validate([
            'id_produksi' => 'required|exists:produksis,id_produksi',
            'id_karyawan' => 'required|array|min:1',
            'id_karyawan.*' => 'required|exists:karyawans,id_karyawan',
            'jumlah_unit' => 'required|integer|min:1',
            'tanggal_produksi' => 'required|date',
        ]);

        // Simpan multiple anggota dalam transaction
        DB::beginTransaction();
        try {
            $karyawanIds = $validatedData['id_karyawan'];
            $count = count($karyawanIds);
            $totalUnits = (int) $validatedData['jumlah_unit'];

            // Bagi rata jumlah_unit ke setiap anggota sehingga total tetap sama
            // Gunakan pembagian integer dengan distribusi sisa ke anggota pertama
            $base = intdiv($totalUnits, $count);
            $remainder = $totalUnits % $count;

            foreach ($karyawanIds as $index => $idKaryawan) {
                $assigned = $base + ($index < $remainder ? 1 : 0);

                ProduksiKaryawanTim::create([
                    'id_produksi' => $validatedData['id_produksi'],
                    'id_karyawan' => $idKaryawan,
                    'jumlah_unit' => $assigned,
                    'tanggal_produksi' => $validatedData['tanggal_produksi'],
                ]);
            }

            DB::commit();
            return redirect()->route('tim_produksi.index')->with('success', 'Anggota tim berhasil ditambahkan untuk produksi tersebut.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('tim_produksi.index')->with('error', 'Gagal menyimpan anggota tim: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Ambil data produksi karyawan tim berdasarkan ID
        $produksiKaryawanTim = ProduksiKaryawanTim::findOrFail($id);

        // Ambil data produksi dan karyawan untuk form
        $produksis = Produksi::all();
        $karyawans = Karyawan::all();

        // Kirim data ke view
        return view('produksi_karyawan_tim.edit', compact('produksiKaryawanTim', 'produksis', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        // Validasi hanya untuk field yang dikirim dari form edit anggota
        $validatedData = $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'jumlah_unit' => 'required|integer|min:1',
            'tanggal_produksi' => 'required|date',
        ]);

        try {
            // Update data di database
            $produksiKaryawanTim = ProduksiKaryawanTim::findOrFail($id);
            $updated = $produksiKaryawanTim->update($validatedData);

            if ($updated) {
                return redirect()->route('tim_produksi.index')->with('success', 'Data produksi karyawan tim berhasil diperbarui!');
            }

            return redirect()->route('tim_produksi.index')->with('error', 'Gagal menyimpan perubahan ke database.');
        } catch (Exception $e) {
            return redirect()->route('tim_produksi.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Hapus data produksi karyawan tim berdasarkan ID
        $produksiKaryawanTim = ProduksiKaryawanTim::findOrFail($id);
        $produksiKaryawanTim->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('tim_produksi.index')->with('success', 'Data produksi karyawan tim berhasil dihapus!');
    }

    public function show($id)
    {
        // Ambil data produksi karyawan tim berdasarkan ID
        $produksiKaryawanTim = ProduksiKaryawanTim::with(['produksi', 'karyawan'])->findOrFail($id);

        // Kirim data ke view
        return view('produksi_karyawan_tim.show', compact('produksiKaryawanTim'));
    }

    /**
     * DETAIL TIM PRODUKSI
     * 
     * Menampilkan detail tim dengan perhitungan upah otomatis
     * - Total Unit Tim
     * - Total Upah Tim
     * - Upah per Karyawan
     * - Daftar anggota tim
     */
    public function detail($id)
    {
        try {
            // Ambil data produksi karyawan tim berdasarkan ID
            $record = ProduksiKaryawanTim::with(['produksi', 'karyawan'])->findOrFail($id);

            // Ambil semua anggota tim berdasarkan produksi dan tanggal yang sama
            $anggotaTim = ProduksiKaryawanTim::where('id_produksi', $record->id_produksi)
                ->whereDate('tanggal_produksi', $record->tanggal_produksi)
                ->with(['karyawan'])
                ->get();

            // Hitung gaji tim menggunakan service (aggregasi by produksi + tanggal)
            $gaji = $this->gajiTimService->hitungGajiTim($record->id_produksi, $record->tanggal_produksi->format('Y-m-d'), $record->produksi);

            // Map service keys to the required output names
            $total_unit_tim = $gaji['total_unit_tim'];
            // service uses total_upah_tim name; map to total_gaji_tim to match requirement
            $total_gaji_tim = $gaji['total_upah_tim'] ?? 0;
            // final per-employee salary
            $gaji_per_karyawan = $gaji['upah_per_karyawan'];
            $jumlah_anggota = $gaji['jumlah_anggota'] ?? 0;

            // Prepare anggota rows for view (no calculations in blade)
            $anggotaRows = $anggotaTim->map(function ($a) use ($total_unit_tim, $gaji_per_karyawan) {
                $jumlah = (int) $a->jumlah_unit;
                $persentase = $total_unit_tim > 0 ? round(($jumlah / $total_unit_tim) * 100, 2) : 0;

                return (object) [
                    'nama' => $a->karyawan->nama ?? 'N/A',
                    'jumlah_unit' => $jumlah,
                    'persentase' => $persentase,
                    'gaji_diterima' => $gaji_per_karyawan,
                ];
            })->values();

            // daftar_karyawan: array of names (for any other uses)
            $daftar_karyawan = $anggotaRows->pluck('nama')->all();

            // Kirim data ke view (no calculation in view)
            return view('produksi_karyawan_tim.detail', compact(
                'record',
                'anggotaRows',
                'total_unit_tim',
                'total_gaji_tim',
                'gaji_per_karyawan',
                'jumlah_anggota',
                'daftar_karyawan'
            ));
        } catch (Exception $e) {
            return redirect()->route('tim_produksi.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * DETAIL TIM PRODUKSI (canonical by produksi id + tanggal)
     * route: /tim-produksi/{id}/{tanggal}
     */
    public function detailByProduction($id, $tanggal)
    {
        try {
            $tanggalCarbon = Carbon::parse($tanggal);

            // Ambil semua anggota tim berdasarkan produksi dan tanggal yang sama
            $anggotaTim = ProduksiKaryawanTim::where('id_produksi', $id)
                ->whereDate('tanggal_produksi', $tanggalCarbon->format('Y-m-d'))
                ->with(['karyawan'])
                ->get();

            // Hitung gaji tim menggunakan service (aggregasi by produksi + tanggal)
            $produksi = Produksi::find($id);
            $gaji = $this->gajiTimService->hitungGajiTim($id, $tanggalCarbon->format('Y-m-d'), $produksi);

            $total_unit_tim = $gaji['total_unit_tim'] ?? $anggotaTim->sum('jumlah_unit');
            $total_gaji_tim = $gaji['total_upah_tim'] ?? 0;
            $gaji_per_karyawan = $gaji['upah_per_karyawan'] ?? 0;
            $jumlah_anggota = $gaji['jumlah_anggota'] ?? $anggotaTim->count();

            // Prepare anggota rows for view (no calculations in blade)
            $anggotaRows = $anggotaTim->map(function ($a) use ($total_unit_tim, $gaji_per_karyawan) {
                $jumlah = (int) $a->jumlah_unit;
                $persentase = $total_unit_tim > 0 ? round(($jumlah / $total_unit_tim) * 100, 2) : 0;

                return (object) [
                    'nama' => $a->karyawan->nama ?? 'N/A',
                    'jumlah_unit' => $jumlah,
                    'persentase' => $persentase,
                    'gaji_diterima' => $gaji_per_karyawan,
                ];
            })->values();

            $produksi = Produksi::find($id);

            $record = (object) [
                'id' => null,
                'id_produksi' => $id,
                'tanggal_produksi' => $tanggalCarbon->toDateString(),
                'produksi' => $produksi,
            ];

            $daftar_karyawan = $anggotaRows->pluck('nama')->all();

            return view('produksi_karyawan_tim.detail', compact(
                'record',
                'anggotaRows',
                'total_unit_tim',
                'total_gaji_tim',
                'gaji_per_karyawan',
                'jumlah_anggota',
                'daftar_karyawan'
            ));
        } catch (Exception $e) {
            return redirect()->route('tim_produksi.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show an edit/manage page for a whole produksi + tanggal group.
     *
     * This allows lightweight management of the group's anggota (list with links
     * to edit individual members) and is used by the dashboard Edit button.
     */
    public function editByProduction($id, $tanggal)
    {
        try {
            $tanggalCarbon = Carbon::parse($tanggal)->format('Y-m-d');

            $anggotaTim = ProduksiKaryawanTim::where('id_produksi', $id)
                ->whereDate('tanggal_produksi', $tanggalCarbon)
                ->with(['karyawan'])
                ->get();

            $produksi = Produksi::find($id);

            return view('produksi_karyawan_tim.edit_group', compact('anggotaTim', 'produksi', 'tanggalCarbon'));
        } catch (Exception $e) {
            return redirect()->route('tim_produksi.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Delete all anggota records for a given produksi + tanggal (group delete).
     */
    public function destroyByProduction($id, $tanggal)
    {
        try {
            $tanggalCarbon = Carbon::parse($tanggal)->format('Y-m-d');

            ProduksiKaryawanTim::where('id_produksi', $id)
                ->whereDate('tanggal_produksi', $tanggalCarbon)
                ->delete();

            return redirect()->route('tim_produksi.index')->with('success', 'Semua anggota tim berhasil dihapus untuk produksi tersebut pada tanggal itu.');
        } catch (Exception $e) {
            return redirect()->route('tim_produksi.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
