<?php

/**
 * CONTROLLER USAGE EXAMPLES
 * 
 * Demonstrasi penggunaan calculation methods dalam controller
 * untuk dashboard, reporting, dan analytics features
 */

// ============================================================
// EXAMPLE 1: Dashboard Controller
// ============================================================

namespace App\Http\Controllers;

use App\Models\TimProduksi;
use App\Models\Produksi;
use App\Models\Karyawan;

class DashboardController extends Controller
{
  /**
   * Dashboard overview dengan daily statistics
   */
  public function index()
  {
    // Get today's production summary
    $dailyStats = TimProduksi::totalPerHari()->first();

    // Get all production statistics for current month
    $monthStats = TimProduksi::statistikRange(
      now()->startOfMonth(),
      now()->endOfMonth()
    );

    // Get top performers today
    $topToday = TimProduksi::totalPerKaryawan()
      ->first(); // Top performer

    return view('dashboard.index', [
      'dailyStats' => $dailyStats,
      'monthStats' => $monthStats,
      'topPerformer' => $topToday,
    ]);
  }
}

// ============================================================
// EXAMPLE 2: Production Analytics Report
// ============================================================

class ProductionReportController extends Controller
{
  /**
   * Generate production analysis report untuk produksi tertentu
   */
  public function show(Produksi $produksi)
  {
    // Get comprehensive production stats
    $stats = [
      'total' => $produksi->getTotalProduksi(),
      'info' => $produksi->getStatistikTimProduksi(),
      'daily' => $produksi->getProduksiPerHari(),
      'team' => $produksi->getBreakdownTimPerKaryawan(),
      'topPerformers' => $produksi->getTopKaryawan(10),
    ];

    return view('production.report', [
      'produksi' => $produksi,
      'stats' => $stats,
    ]);
  }

  /**
   * Export production report to PDF
   */
  public function exportPdf(Produksi $produksi)
  {
    $data = [
      'produksi' => $produksi,
      'total' => $produksi->getTotalProduksi(),
      'stats' => $produksi->getStatistikTimProduksi(),
      'breakdown' => $produksi->getBreakdownTimPerKaryawan(),
      'topPerformers' => $produksi->getTopKaryawan(10),
    ];

    return PDF::loadView('production.report-pdf', $data)
      ->download("production-report-{$produksi->id_produksi}.pdf");
  }
}

// ============================================================
// EXAMPLE 3: Employee Performance Controller
// ============================================================

class EmployeePerformanceController extends Controller
{
  /**
   * Employee detailed performance report
   */
  public function show(Karyawan $karyawan)
  {
    // Get comprehensive employee stats
    $stats = [
      'total' => $karyawan->getTotalKontribusi(),
      'info' => $karyawan->getStatistikKontribusi(),
      'daily' => $karyawan->getKontribusiPerHari(),
      'byProduct' => $karyawan->getBreakdownPerProduksi(),
      'daysWorked' => $karyawan->getJumlahHariKerja(),
      'monthlyPerf' => $karyawan->getPerformaBulan(now()->format('Y-m')),
      'productList' => $karyawan->getProdukYangDikerjakan(),
      'history' => $karyawan->getPerformaHarianDetail(),
    ];

    return view('employee.performance', [
      'karyawan' => $karyawan,
      'stats' => $stats,
    ]);
  }

  /**
   * Monthly performance for specific employee
   */
  public function monthlyReport(Karyawan $karyawan, $bulan)
  {
    // Validasi format bulan: Y-m
    if (!preg_match('/^\d{4}-\d{2}$/', $bulan)) {
      abort(400, 'Invalid month format');
    }

    $perf = $karyawan->getPerformaBulan($bulan);

    return view('employee.monthly-report', [
      'karyawan' => $karyawan,
      'bulan' => $bulan,
      'performance' => $perf,
      'detail' => $karyawan->getPerformaHarianDetail()
        ->filter(function ($item) use ($bulan) {
          return $item->tanggal_produksi->format('Y-m') === $bulan;
        }),
    ]);
  }

  /**
   * Compare multiple employees
   */
  public function compare(array $ids)
  {
    $employees = Karyawan::whereIn('id_karyawan', $ids)->get();

    $comparison = $employees->map(function ($emp) {
      return [
        'employee' => $emp,
        'stats' => $emp->getStatistikKontribusi(),
        'monthly' => $emp->getPerformaBulan(now()->format('Y-m')),
      ];
    });

    return view('employee.comparison', [
      'comparison' => $comparison,
    ]);
  }
}

// ============================================================
// EXAMPLE 4: Reporting API Controller
// ============================================================

class ReportingApiController extends Controller
{
  /**
   * GET /api/daily-stats
   * Daily production statistics JSON
   */
  public function dailyStats()
  {
    $stats = TimProduksi::totalPerHari();

    return response()->json([
      'success' => true,
      'data' => $stats,
    ]);
  }

  /**
   * GET /api/employee/{id}/stats
   * Employee statistics JSON
   */
  public function employeeStats(Karyawan $karyawan)
  {
    return response()->json([
      'success' => true,
      'data' => [
        'employee' => $karyawan,
        'total' => $karyawan->getTotalKontribusi(),
        'stats' => $karyawan->getStatistikKontribusi(),
        'monthly' => $karyawan->getPerformaBulan(now()->format('Y-m')),
      ],
    ]);
  }

  /**
   * GET /api/production/{id}/stats
   * Production statistics JSON
   */
  public function productionStats(Produksi $produksi)
  {
    return response()->json([
      'success' => true,
      'data' => [
        'production' => $produksi,
        'total' => $produksi->getTotalProduksi(),
        'stats' => $produksi->getStatistikTimProduksi(),
        'topPerformers' => $produksi->getTopKaryawan(5),
      ],
    ]);
  }

  /**
   * GET /api/statistics/range?from=2026-01-01&to=2026-01-31
   * Range statistics JSON
   */
  public function rangeStatistics()
  {
    $from = request()->query('from', now()->startOfMonth());
    $to = request()->query('to', now()->endOfMonth());

    $stats = TimProduksi::statistikRange($from, $to);

    return response()->json([
      'success' => true,
      'range' => [
        'from' => $from,
        'to' => $to,
      ],
      'data' => $stats,
    ]);
  }
}

// ============================================================
// EXAMPLE 5: Export Controller (CSV/Excel)
// ============================================================

class ExportController extends Controller
{
  /**
   * Export daily statistics to CSV
   */
  public function dailyStatsCsv()
  {
    $filename = "daily-statistics-" . now()->format('Y-m-d') . ".csv";

    $callback = function () {
      $output = fopen('php://output', 'w');

      // Header
      fputcsv($output, ['Tanggal', 'Total Produksi', 'Jumlah Karyawan']);

      // Data
      foreach (TimProduksi::totalPerHari() as $row) {
        fputcsv($output, [
          $row->tanggal_produksi,
          $row->total_produksi,
          $row->jumlah_karyawan,
        ]);
      }

      fclose($output);
    };

    return response()->streamDownload($callback, $filename);
  }

  /**
   * Export employee performance to Excel
   */
  public function employeePerformanceExcel()
  {
    return Excel::download(
      new EmployeePerformanceExport(),
      'employee-performance-' . now()->format('Y-m-d') . '.xlsx'
    );
  }

  /**
   * Export monthly report for all employees
   */
  public function monthlyReportExcel($bulan)
  {
    return Excel::download(
      new MonthlyReportExport($bulan),
      'monthly-report-' . $bulan . '.xlsx'
    );
  }
}

// ============================================================
// EXAMPLE 6: Export Classes (untuk Excel)
// ============================================================

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeePerformanceExport implements FromCollection, WithHeadings
{
  public function collection()
  {
    $employees = Karyawan::all();

    $data = [];
    foreach ($employees as $emp) {
      $stats = $emp->getStatistikKontribusi();
      $monthly = $emp->getPerformaBulan(now()->format('Y-m'));

      $data[] = [
        'ID' => $emp->id_karyawan,
        'Nama' => $emp->nama_karyawan,
        'Total Kontribusi' => $stats['total_kontribusi'],
        'Hari Kerja' => $stats['hari_bekerja'],
        'Rata-rata' => round($stats['rata_rata_per_hari'], 2),
        'Bulan Ini' => $monthly['total_kontribusi'],
        'Bulan - Hari' => $monthly['hari_kerja'],
      ];
    }

    return collect($data);
  }

  public function headings(): array
  {
    return [
      'ID',
      'Nama',
      'Total Kontribusi',
      'Hari Kerja',
      'Rata-rata',
      'Bulan Ini',
      'Bulan - Hari Kerja',
    ];
  }
}

// ============================================================
// EXAMPLE 7: Routes Implementation
// ============================================================

// routes/web.php
Route::middleware(['auth', 'verified'])->group(function () {
  // Dashboard
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Production Reports
  Route::get('/production/{produksi}/report', [ProductionReportController::class, 'show'])
    ->name('production.report');
  Route::get('/production/{produksi}/report/pdf', [ProductionReportController::class, 'exportPdf'])
    ->name('production.report.pdf');

  // Employee Performance
  Route::get('/employee/{karyawan}/performance', [EmployeePerformanceController::class, 'show'])
    ->name('employee.performance');
  Route::get('/employee/{karyawan}/performance/{bulan}', [EmployeePerformanceController::class, 'monthlyReport'])
    ->name('employee.performance.monthly');
  Route::post('/employee/compare', [EmployeePerformanceController::class, 'compare'])
    ->name('employee.compare');

  // Exports
  Route::get('/export/daily-stats/csv', [ExportController::class, 'dailyStatsCsv'])
    ->name('export.daily-stats.csv');
  Route::get('/export/employee-performance/excel', [ExportController::class, 'employeePerformanceExcel'])
    ->name('export.employee-performance.excel');
  Route::get('/export/monthly-report/{bulan}/excel', [ExportController::class, 'monthlyReportExcel'])
    ->name('export.monthly-report.excel');
});

// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
  Route::get('/daily-stats', [ReportingApiController::class, 'dailyStats']);
  Route::get('/employee/{karyawan}/stats', [ReportingApiController::class, 'employeeStats']);
  Route::get('/production/{produksi}/stats', [ReportingApiController::class, 'productionStats']);
  Route::get('/statistics/range', [ReportingApiController::class, 'rangeStatistics']);
});

// ============================================================
// EXAMPLE 8: Blade Template Usage
// ============================================================

/*
<!-- resources/views/dashboard/index.blade.php -->
<div class="dashboard">
    <h1>Production Dashboard</h1>

    <!-- Daily Stats -->
    <div class="card">
        <h2>Today's Production</h2>
        <p>Total: {{ $dailyStats->total_produksi ?? 0 }} units</p>
        <p>Employees: {{ $dailyStats->jumlah_karyawan ?? 0 }}</p>
    </div>

    <!-- Monthly Chart -->
    <div class="card">
        <h2>Monthly Statistics</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Total</th>
                <th>Employees</th>
                <th>Avg</th>
            </tr>
            @foreach($monthStats as $stat)
                <tr>
                    <td>{{ $stat->tanggal_produksi }}</td>
                    <td>{{ $stat->total_produksi }}</td>
                    <td>{{ $stat->jumlah_karyawan }}</td>
                    <td>{{ round($stat->rata_rata, 2) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<!-- resources/views/employee/performance.blade.php -->
<div class="performance">
    <h1>{{ $karyawan->nama_karyawan }} - Performance</h1>

    <div class="stats">
        <p>Total Contribution: {{ $stats['info']['total_kontribusi'] }}</p>
        <p>Days Worked: {{ $stats['info']['hari_bekerja'] }}</p>
        <p>Average/Day: {{ round($stats['info']['rata_rata_per_hari'], 2) }}</p>
    </div>

    <div class="monthly">
        <h2>This Month</h2>
        <p>Total: {{ $stats['monthlyPerf']['total_kontribusi'] }}</p>
        <p>Days: {{ $stats['monthlyPerf']['hari_kerja'] }}</p>
    </div>

    <div class="products">
        <h2>Products</h2>
        @foreach($stats['productList'] as $product)
            <p>{{ $product->produksi->nama_produk }}: {{ $product->total_kontribusi }}</p>
        @endforeach
    </div>
</div>
*/

// ============================================================
// SUMMARY
// ============================================================

/**
 * Key Points:
 * 
 * 1. Controller hanya memanggil calculation methods
 * 2. Methods mengembalikan fresh data (on-demand)
 * 3. No caching, no permanent storage
 * 4. Results siap langsung untuk view/response
 * 5. Aggregations calculated via database queries
 * 6. Scalable untuk besar data
 * 
 * Usage:
 * - Dashboard: Quick overview statistics
 * - Reports: Detailed analysis per entity
 * - Export: CSV/PDF/Excel generation
 * - API: JSON endpoints untuk frontend
 * - Comparison: Multi-entity analysis
 */
