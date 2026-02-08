<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;

class ProdukController extends Controller
{
    public function index()
    {
        // Server-side sorting + pagination (safe defaults)
        $allowed = ['id_produk', 'nama_produk', 'harga_satuan', 'stok_tersedia', 'created_at'];
        $sort = request('sort', 'nama_produk');
        $direction = request('direction', 'asc') === 'desc' ? 'desc' : 'asc';
        if (!in_array($sort, $allowed)) {
            $sort = 'nama_produk';
        }

        $perPage = 15;
        $DataBarang = Produk::select('id_produk', 'nama_produk', 'gambar_produk', 'harga_satuan', 'stok_tersedia', 'created_at')
            ->orderBy($sort, $direction)
            ->paginate($perPage);

        return view('produk.dashboard_produk', ['KurirData' => $DataBarang]);
    }

    public function __construct()
    {
        // Require authentication for mutation routes; allow guests to view index/show
        $this->middleware('auth')->except(['index', 'show']);
        // TODO: middleware not registered, removed for safety
    }

    /**
     * Pragmatic Excel export - streams CSV (Excel-readable)
     */
    public function exportExcel()
    {
        $user = auth()->user();
        if (!$user || !$user->can('export produk')) {
            abort(403);
        }

        $produks = Produk::all();
        $filename = 'produk_export_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($produks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id_produk', 'nama_produk', 'harga_satuan', 'stok_tersedia', 'deskripsi_produk', 'created_at']);
            foreach ($produks as $p) {
                fputcsv($handle, [$p->id_produk, $p->nama_produk, $p->harga_satuan, $p->stok_tersedia, strip_tags($p->deskripsi_produk ?? ''), optional($p->created_at)->toDateTimeString()]);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function show($id_produk)
    {
        $DataBarang = Produk::find($id_produk);
        return view('produk.profil_produk', ['KurirData' => $DataBarang]);
    }

    public function create()
    {
        return view('produk.form_tambah_produk');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gambar_produk' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'harga_satuan' => 'required|numeric|min:0',
            'stok_tersedia' => 'required|integer|min:0',
            'deskripsi_produk' => 'nullable|string|max:1000', // Validasi deskripsi
        ]);

        if ($request->hasFile('gambar_produk')) {
            $path = $request->file('gambar_produk')->store('gambar_produk', 'public');
            $validatedData['gambar_produk'] = $path; // relative path (gambar_produk/xxx.jpg)
            Log::info('Produk gambar disimpan', ['path' => $path]);
        }

        Produk::create($validatedData);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id); // Pastikan produk ditemukan
        return view('produk.form_edit_produk', ['produk' => $produk]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id); // Pastikan produk ditemukan

        // Validasi input
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'harga_satuan' => 'required|numeric|min:0',
            'stok_tersedia' => 'required|integer|min:0',
            'deskripsi_produk' => 'nullable|string|max:1000', // Validasi deskripsi
        ]);

        // Jika ada file gambar baru, hapus gambar lama dan simpan gambar baru
        if ($request->hasFile('gambar_produk')) {
            // Simpan gambar baru ke disk 'public' dan log path
            $path = $request->file('gambar_produk')->store('gambar_produk', 'public');
            $validatedData['gambar_produk'] = $path;
            Log::info('Produk gambar diperbarui', ['id' => $produk->id_produk, 'path' => $path]);
        }

        // Update data produk
        $produk->update($validatedData);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }


    public function delete($id)
    {
        $produk = Produk::findOrFail($id);

        return redirect()->route('produk.index')->with('pesan', "Hapus data $produk->nama_produk berhasil");
    }

    public function getRouteKeyName()
    {
        return 'id_produk';
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Export produk as CSV (requires permission 'export produk')
     */
    public function exportCsv()
    {
        $user = auth()->user();
        if (!$user || !$user->can('export produk')) {
            abort(403);
        }

        $produks = Produk::all();
        $filename = 'produk_export_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($produks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id_produk', 'nama_produk', 'harga_satuan', 'stok_tersedia', 'deskripsi_produk', 'created_at']);
            foreach ($produks as $p) {
                fputcsv($handle, [$p->id_produk, $p->nama_produk, $p->harga_satuan, $p->stok_tersedia, strip_tags($p->deskripsi_produk ?? ''), optional($p->created_at)->toDateTimeString()]);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export produk as PDF using Dompdf (requires permission 'export produk')
     */
    public function exportPdf()
    {
        $user = auth()->user();
        if (!$user || !$user->can('export produk')) {
            abort(403);
        }

        $produks = Produk::all();
        $html = view('produk.exports.pdf', compact('produks'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="produk_export_' . date('Ymd_His') . '.pdf"',
        ]);
    }
}