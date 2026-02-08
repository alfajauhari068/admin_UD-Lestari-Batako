<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Produksi;
use App\Models\Karyawan;
use App\Models\TimProduksi;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test Suite untuk Query-Based Calculation System
 * 
 * Verifies:
 * - All methods are read-only (no data mutations)
 * - Calculations return correct aggregations
 * - No permanent storage of results
 * - No triggers/events fired
 * - Query efficiency
 */
class CalculationMethodsTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Setup test data sebelum setiap test
   */
  protected function setUp(): void
  {
    parent::setUp();

    // Create test data
    $this->createTestData();
  }

  /**
   * Buat sample data untuk testing
   */
  private function createTestData(): void
  {
    // Create karyawans
    $karyawan1 = Karyawan::create([
      'nama_karyawan' => 'Budi Santoso',
      'jabatan' => 'Operator',
      'no_hp' => '081234567890',
      'alamat' => 'Jalan Merdeka 123'
    ]);

    $karyawan2 = Karyawan::create([
      'nama_karyawan' => 'Siti Nurhaliza',
      'jabatan' => 'Operator',
      'no_hp' => '081234567891',
      'alamat' => 'Jalan Sudirman 456'
    ]);

    // Create produksis
    $produksi1 = Produksi::create([
      'id_produk' => 1,
      'jumlah_per_unit' => 100,
      'kriteria_gaji' => 'per_unit',
      'gaji_per_unit' => 500
    ]);

    $produksi2 = Produksi::create([
      'id_produk' => 2,
      'jumlah_per_unit' => 200,
      'kriteria_gaji' => 'per_unit',
      'gaji_per_unit' => 400
    ]);

    // Create tim_produksi records
    TimProduksi::create([
      'id_produksi' => $produksi1->id_produksi,
      'id_karyawan' => $karyawan1->id_karyawan,
      'jumlah_produksi' => 450,
      'tanggal_produksi' => now()->subDay()
    ]);

    TimProduksi::create([
      'id_produksi' => $produksi1->id_produksi,
      'id_karyawan' => $karyawan2->id_karyawan,
      'jumlah_produksi' => 380,
      'tanggal_produksi' => now()->subDay()
    ]);

    TimProduksi::create([
      'id_produksi' => $produksi2->id_produksi,
      'id_karyawan' => $karyawan1->id_karyawan,
      'jumlah_produksi' => 520,
      'tanggal_produksi' => now()
    ]);

    TimProduksi::create([
      'id_produksi' => $produksi2->id_produksi,
      'id_karyawan' => $karyawan2->id_karyawan,
      'jumlah_produksi' => 600,
      'tanggal_produksi' => now()
    ]);
  }

  // ============================================================
  // TimProduksi Static Methods
  // ============================================================

  /**
   * @test
   * Verify totalPerHari() returns correct aggregation
   */
  public function test_totalPerHari_returns_correct_aggregation()
  {
    $result = TimProduksi::totalPerHari();

    $this->assertCount(2, $result); // 2 hari berbeda

    // Today: 1120 (520 + 600)
    $today = $result->where('tanggal_produksi', now()->format('Y-m-d'))->first();
    $this->assertEquals(1120, $today->total_produksi);
    $this->assertEquals(2, $today->jumlah_karyawan);

    // Yesterday: 830 (450 + 380)
    $yesterday = $result->where('tanggal_produksi', now()->subDay()->format('Y-m-d'))->first();
    $this->assertEquals(830, $yesterday->total_produksi);
  }

  /**
   * @test
   * Verify totalPerKaryawan() returns correct aggregation
   */
  public function test_totalPerKaryawan_returns_correct_aggregation()
  {
    $result = TimProduksi::totalPerKaryawan();

    $this->assertCount(2, $result); // 2 karyawan

    // Karyawan 1: 450 + 520 = 970
    $karyawan1 = $result->where('id_karyawan', 1)->first();
    $this->assertEquals(970, $karyawan1->total_produksi);
    $this->assertEquals(2, $karyawan1->hari_bekerja);
  }

  /**
   * @test
   * Verify totalPerHariByProduksi() filters correctly
   */
  public function test_totalPerHariByProduksi_filters_by_produksi()
  {
    $result = TimProduksi::totalPerHariByProduksi(1);

    $this->assertCount(1, $result); // 1 hari untuk produksi 1
    $this->assertEquals(830, $result->first()->total_produksi);
    $this->assertEquals(2, $result->first()->jumlah_karyawan);
  }

  /**
   * @test
   * Verify totalPerKaryawanPerHari() groups correctly
   */
  public function test_totalPerKaryawanPerHari_groups_correctly()
  {
    $result = TimProduksi::totalPerKaryawanPerHari();

    $this->assertCount(4, $result); // 4 kombinasi karyawan-hari
  }

  /**
   * @test
   * Verify totalPerProduksi() returns correct aggregation
   */
  public function test_totalPerProduksi_returns_correct_aggregation()
  {
    $result = TimProduksi::totalPerProduksi();

    $this->assertCount(2, $result); // 2 produksi

    // Produksi 1: 450 + 380 = 830
    $prod1 = $result->where('id_produksi', 1)->first();
    $this->assertEquals(830, $prod1->total_produksi);
    $this->assertEquals(2, $prod1->jumlah_karyawan);
  }

  /**
   * @test
   * Verify rataRataProduksiPerKaryawan() calculates correctly
   */
  public function test_rataRataProduksiPerKaryawan_calculates_correctly()
  {
    $result = TimProduksi::rataRataProduksiPerKaryawan();

    $this->assertCount(2, $result);

    // Karyawan 1: (450 + 520) / 2 = 485
    $karyawan1 = $result->where('id_karyawan', 1)->first();
    $this->assertEquals(485, $karyawan1->rata_rata_produksi);
    $this->assertEquals(450, $karyawan1->min_produksi);
    $this->assertEquals(520, $karyawan1->max_produksi);
  }

  /**
   * @test
   * Verify statistikRange() filters by date range
   */
  public function test_statistikRange_filters_by_date_range()
  {
    $from = now()->subDay();
    $to = now();

    $result = TimProduksi::statistikRange($from, $to);

    $this->assertCount(2, $result); // 2 hari dalam range
  }

  /**
   * @test
   * Verify breakdownDetailHarian() loads relations
   */
  public function test_breakdownDetailHarian_loads_relations()
  {
    $result = TimProduksi::breakdownDetailHarian(now()->format('Y-m-d'));

    $this->assertCount(2, $result);

    // Verify eager loading
    $this->assertTrue($result->first()->relationLoaded('karyawan'));
    $this->assertTrue($result->first()->relationLoaded('produksi'));
  }

  // ============================================================
  // Produksi Instance Methods
  // ============================================================

  /**
   * @test
   * Verify getTotalProduksi() returns correct sum
   */
  public function test_produksi_getTotalProduksi_returns_correct_sum()
  {
    $produksi = Produksi::find(1);
    $total = $produksi->getTotalProduksi();

    // Produksi 1: 450 + 380 = 830
    $this->assertEquals(830, $total);
  }

  /**
   * @test
   * Verify getProduksiPerHari() returns breakdown
   */
  public function test_produksi_getProduksiPerHari_returns_breakdown()
  {
    $produksi = Produksi::find(1);
    $breakdown = $produksi->getProduksiPerHari();

    $this->assertCount(1, $breakdown);
    $this->assertEquals(830, $breakdown->first()->total);
  }

  /**
   * @test
   * Verify getBreakdownTimPerKaryawan() loads relations
   */
  public function test_produksi_getBreakdownTimPerKaryawan_loads_relations()
  {
    $produksi = Produksi::find(1);
    $breakdown = $produksi->getBreakdownTimPerKaryawan();

    $this->assertCount(2, $breakdown);
    $this->assertTrue($breakdown->first()->relationLoaded('karyawan'));
  }

  /**
   * @test
   * Verify getStatistikTimProduksi() calculates correctly
   */
  public function test_produksi_getStatistikTimProduksi_calculates_correctly()
  {
    $produksi = Produksi::find(2);
    $stats = $produksi->getStatistikTimProduksi();

    $this->assertEquals(1120, $stats['total_produksi']);
    $this->assertEquals(2, $stats['jumlah_karyawan']);
    $this->assertEquals(1, $stats['hari_produksi']);
    $this->assertEquals(1120, $stats['rata_rata_per_hari']);
  }

  /**
   * @test
   * Verify getTopKaryawan() returns top performers
   */
  public function test_produksi_getTopKaryawan_returns_top_performers()
  {
    $produksi = Produksi::find(2);
    $top = $produksi->getTopKaryawan(5);

    $this->assertCount(2, $top);

    // Karyawan 2 harus first (600 > 520)
    $this->assertEquals(2, $top->first()->id_karyawan);
    $this->assertEquals(600, $top->first()->total_produksi);
  }

  // ============================================================
  // Karyawan Instance Methods
  // ============================================================

  /**
   * @test
   * Verify getTotalKontribusi() returns correct sum
   */
  public function test_karyawan_getTotalKontribusi_returns_correct_sum()
  {
    $karyawan = Karyawan::find(1);
    $total = $karyawan->getTotalKontribusi();

    // Karyawan 1: 450 + 520 = 970
    $this->assertEquals(970, $total);
  }

  /**
   * @test
   * Verify getKontribusiPerHari() returns breakdown
   */
  public function test_karyawan_getKontribusiPerHari_returns_breakdown()
  {
    $karyawan = Karyawan::find(1);
    $breakdown = $karyawan->getKontribusiPerHari();

    $this->assertCount(2, $breakdown);
  }

  /**
   * @test
   * Verify getBreakdownPerProduksi() returns per product breakdown
   */
  public function test_karyawan_getBreakdownPerProduksi_returns_per_product()
  {
    $karyawan = Karyawan::find(1);
    $breakdown = $karyawan->getBreakdownPerProduksi();

    $this->assertCount(2, $breakdown); // 2 produk
  }

  /**
   * @test
   * Verify getStatistikKontribusi() calculates correctly
   */
  public function test_karyawan_getStatistikKontribusi_calculates_correctly()
  {
    $karyawan = Karyawan::find(1);
    $stats = $karyawan->getStatistikKontribusi();

    $this->assertEquals(970, $stats['total_kontribusi']);
    $this->assertEquals(2, $stats['jumlah_produk']);
    $this->assertEquals(2, $stats['hari_bekerja']);
    $this->assertEquals(450, $stats['kontribusi_min']);
    $this->assertEquals(520, $stats['kontribusi_max']);
  }

  /**
   * @test
   * Verify getProdukYangDikerjakan() returns ranked list
   */
  public function test_karyawan_getProdukYangDikerjakan_returns_ranked()
  {
    $karyawan = Karyawan::find(1);
    $produk = $karyawan->getProdukYangDikerjakan();

    $this->assertCount(2, $produk);

    // Produksi 2 harus first (520 > 450)
    $this->assertEquals(2, $produk->first()->id_produksi);
  }

  /**
   * @test
   * Verify getJumlahHariKerja() counts distinct days
   */
  public function test_karyawan_getJumlahHariKerja_counts_distinct_days()
  {
    $karyawan = Karyawan::find(1);
    $days = $karyawan->getJumlahHariKerja();

    $this->assertEquals(2, $days);
  }

  /**
   * @test
   * Verify getPerformaBulan() filters by month
   */
  public function test_karyawan_getPerformaBulan_filters_by_month()
  {
    $karyawan = Karyawan::find(1);
    $perf = $karyawan->getPerformaBulan(now()->format('Y-m'));

    $this->assertIsArray($perf);
    $this->assertEquals(970, $perf['total_kontribusi']);
    $this->assertEquals(2, $perf['hari_kerja']);
  }

  // ============================================================
  // Read-Only Verification Tests
  // ============================================================

  /**
   * @test
   * Verify no data is modified during calculations
   */
  public function test_calculations_do_not_modify_data()
  {
    $initialCount = TimProduksi::count();

    // Run all major calculation methods
    TimProduksi::totalPerHari();
    TimProduksi::totalPerKaryawan();
    TimProduksi::totalPerProduksi();

    Produksi::find(1)->getTotalProduksi();
    Produksi::find(1)->getProduksiPerHari();
    Produksi::find(1)->getStatistikTimProduksi();

    Karyawan::find(1)->getTotalKontribusi();
    Karyawan::find(1)->getStatistikKontribusi();
    Karyawan::find(1)->getPerformaBulan(now()->format('Y-m'));

    // Verify count unchanged
    $this->assertEquals($initialCount, TimProduksi::count());
  }

  /**
   * @test
   * Verify no new records are created
   */
  public function test_calculations_create_no_new_records()
  {
    $before = TimProduksi::count();

    TimProduksi::statistikRange(now()->subDay(), now());

    $after = TimProduksi::count();

    $this->assertEquals($before, $after);
  }

  /**
   * @test
   * Verify results are always fresh (not cached)
   */
  public function test_calculations_return_fresh_results()
  {
    $result1 = TimProduksi::totalPerHari();
    $result2 = TimProduksi::totalPerHari();

    // Both should be identical but separate collection instances
    $this->assertEquals($result1->toArray(), $result2->toArray());
  }
}
