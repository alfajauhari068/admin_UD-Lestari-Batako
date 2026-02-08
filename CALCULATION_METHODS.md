# Query-Based Calculation System

## Deskripsi

Sistem perhitungan berbasis query untuk otomatisasi kalkulasi produksi tanpa menyimpan hasil permanen. Semua metode bersifat read-only dan tidak mengubah data.

---

## 1. TimProduksi Model - Static Reporting Methods

### 1.1 Total Produksi Per Hari (Semua Employee)

```php
// Query: GROUP BY tanggal_produksi
// Return: Collection dengan total per hari
TimProduksi::totalPerHari();

// Output example:
// [
//     {tanggal_produksi: '2026-01-31', total_produksi: 1250, jumlah_karyawan: 5},
//     {tanggal_produksi: '2026-01-30', total_produksi: 980, jumlah_karyawan: 4},
// ]
```

### 1.2 Total Produksi Per Hari Per Produk

```php
// Query: GROUP BY tanggal_produksi, id_produksi
// Return: Collection breakdown per produk per hari
TimProduksi::totalPerHariByProduksi($id_produksi);

// Contoh:
TimProduksi::totalPerHariByProduksi(1);
// Output: Total produksi untuk produk ID=1 per hari
```

### 1.3 Total Produksi Per Karyawan (All Time)

```php
// Query: GROUP BY id_karyawan
// Return: Collection dengan total per karyawan
TimProduksi::totalPerKaryawan();

// Output example:
// [
//     {id_karyawan: 3, total_produksi: 5600, hari_bekerja: 12},
//     {id_karyawan: 1, total_produksi: 4200, hari_bekerja: 10},
// ]
```

### 1.4 Total Produksi Per Karyawan Per Hari

```php
// Query: GROUP BY id_karyawan, tanggal_produksi
// Return: Detail breakdown per karyawan per hari
TimProduksi::totalPerKaryawanPerHari();

// Output: Setiap kombinasi karyawan-hari dengan total produksi
```

### 1.5 Total Produksi Per Produksi

```php
// Query: GROUP BY id_produksi
// Return: Total produksi per produk
TimProduksi::totalPerProduksi();

// Output example:
// [
//     {id_produksi: 5, total_produksi: 8900, jumlah_karyawan: 6, hari_produksi: 8},
// ]
```

### 1.6 Breakdown Detail Harian

```php
// Query: Eager load karyawan & produksi detail
// Return: Semua record untuk tanggal tertentu dengan relasi
TimProduksi::breakdownDetailHarian('2026-01-31');

// Output: Detail per employee dengan nama karyawan & produk
```

### 1.7 Rata-Rata Produksi Per Karyawan

```php
// Query: GROUP BY id_karyawan dengan AVG, MIN, MAX
// Return: Statistik distribusi per karyawan
TimProduksi::rataRataProduksiPerKaryawan();

// Output example:
// [
//     {id_karyawan: 1, rata_rata_produksi: 420, min_produksi: 350, max_produksi: 500},
// ]
```

### 1.8 Statistik Range Tanggal

```php
// Query: GROUP BY tanggal_produksi dengan statistik lengkap
// Return: Daily statistics dengan COUNT, SUM, AVG, MIN, MAX
TimProduksi::statistikRange('2026-01-01', '2026-01-31');

// Output example:
// [
//     {
//         tanggal_produksi: '2026-01-31',
//         jumlah_karyawan: 5,
//         jumlah_produk: 3,
//         total_produksi: 1250,
//         rata_rata: 250,
//         min: 180,
//         max: 380
//     }
// ]
```

---

## 2. Produksi Model - Convenience Methods

### 2.1 Total Produksi untuk Produksi Tertentu

```php
$produksi = Produksi::find(5);
$total = $produksi->getTotalProduksi();

// Query: SELECT SUM(jumlah_produksi) FROM tim_produksi WHERE id_produksi = 5
// Return: Integer
// Output: 8900
```

### 2.2 Produksi Per Hari untuk Produksi Ini

```php
$produksi = Produksi::find(5);
$perHari = $produksi->getProduksiPerHari();

// Query: GROUP BY tanggal_produksi WHERE id_produksi = 5
// Return: Collection
// Output:
// [
//     {tanggal_produksi: '2026-01-31', total: 450, jumlah_karyawan: 3},
//     {tanggal_produksi: '2026-01-30', total: 380, jumlah_karyawan: 2},
// ]
```

### 2.3 Breakdown Tim Per Karyawan

```php
$produksi = Produksi::find(5);
$breakdown = $produksi->getBreakdownTimPerKaryawan();

// Query: GROUP BY id_karyawan WHERE id_produksi = 5
// Return: Collection dengan eager load karyawan
// Output: Top contributors untuk produksi ini
```

### 2.4 Statistik Lengkap Tim Produksi

```php
$produksi = Produksi::find(5);
$stats = $produksi->getStatistikTimProduksi();

// Return: Array dengan:
// [
//     'total_produksi' => 8900,
//     'jumlah_karyawan' => 6,
//     'hari_produksi' => 8,
//     'rata_rata_per_hari' => 1112.5
// ]
```

### 2.5 Top Performers (Top 5)

```php
$produksi = Produksi::find(5);
$top = $produksi->getTopKaryawan(5);

// Query: GROUP BY id_karyawan WHERE id_produksi = 5, ORDER BY total DESC LIMIT 5
// Return: Collection dengan eager load karyawan
// Output: 5 karyawan dengan kontribusi tertinggi
```

---

## 3. Karyawan Model - Convenience Methods

### 3.1 Total Kontribusi Karyawan (All Time)

```php
$karyawan = Karyawan::find(3);
$total = $karyawan->getTotalKontribusi();

// Query: SELECT SUM(jumlah_produksi) FROM tim_produksi WHERE id_karyawan = 3
// Return: Integer
// Output: 5600
```

### 3.2 Kontribusi Per Hari

```php
$karyawan = Karyawan::find(3);
$perHari = $karyawan->getKontribusiPerHari();

// Query: GROUP BY tanggal_produksi WHERE id_karyawan = 3
// Return: Collection
// Output: Daily breakdown untuk karyawan ini
```

### 3.3 Breakdown Per Produk

```php
$karyawan = Karyawan::find(3);
$breakdown = $karyawan->getBreakdownPerProduksi();

// Query: GROUP BY id_produksi WHERE id_karyawan = 3
// Return: Collection dengan eager load produksi
// Output: Kontribusi per produk yang dikerjakan
```

### 3.4 Statistik Kontribusi Lengkap

```php
$karyawan = Karyawan::find(3);
$stats = $karyawan->getStatistikKontribusi();

// Return: Array dengan:
// [
//     'total_kontribusi' => 5600,
//     'jumlah_produk' => 4,
//     'hari_bekerja' => 12,
//     'rata_rata_per_hari' => 466.67,
//     'rata_rata_per_produk' => 1400,
//     'kontribusi_min' => 300,
//     'kontribusi_max' => 650
// ]
```

### 3.5 Produk Yang Dikerjakan (Ranked)

```php
$karyawan = Karyawan::find(3);
$produk = $karyawan->getProdukYangDikerjakan();

// Query: GROUP BY id_produksi WHERE id_karyawan = 3 ORDER BY total DESC
// Return: Collection dengan eager load produksi detail
// Output: Daftar produk ranked by kontribusi
```

### 3.6 Performa Harian Detail

```php
$karyawan = Karyawan::find(3);
$detail = $karyawan->getPerformaHarianDetail();

// Query: Eager load semua tim_produksi records dengan produksi detail
// Return: Collection dengan setiap row lengkap
// Output: Complete history dengan produk info
```

### 3.7 Jumlah Hari Kerja

```php
$karyawan = Karyawan::find(3);
$hariKerja = $karyawan->getJumlahHariKerja();

// Query: COUNT(DISTINCT tanggal_produksi) WHERE id_karyawan = 3
// Return: Integer
// Output: 12 hari
```

### 3.8 Performa Bulan Tertentu

```php
$karyawan = Karyawan::find(3);
$perf = $karyawan->getPerformaBulan('2026-01');

// Query: Filter by DATE_FORMAT(tanggal_produksi, '%Y-%m') = '2026-01'
// Return: Array dengan:
// [
//     'bulan' => '2026-01',
//     'total_kontribusi' => 1850,
//     'hari_kerja' => 5,
//     'rata_rata_per_hari' => 370,
//     'jumlah_produk' => 3
// ]
```

---

## 4. Characteristics & Guarantees

### 4.1 Read-Only Operations

✓ Semua metode hanya melakukan SELECT queries  
✓ Tidak ada UPDATE, DELETE, INSERT  
✓ Tidak ada data yang tersimpan ke database  
✓ Hasil dihitung on-demand saat method dipanggil

### 4.2 No Permanent Storage

✓ Hasil tidak disimpan ke tabel agregasi  
✓ Tidak ada cache table yang diupdate  
✓ Setiap call melakukan fresh calculation dari tim_produksi  
✓ Hasil always accurate dengan data terbaru

### 4.3 No Automatic Triggers

✓ Tidak ada event listeners  
✓ Tidak ada observers  
✓ Tidak ada after_insert/after_update hooks  
✓ Calculations triggered manual saja via method calls

### 4.4 No Background Jobs

✓ Tidak ada queue jobs  
✓ Tidak ada scheduled tasks  
✓ Tidak ada cron entries  
✓ Sinkron execution, hasil langsung available

### 4.5 Performance Considerations

- GROUP BY queries dapat slow jika tim_produksi table sangat besar
- Pertimbangkan eager loading untuk relasi jika butuh detail data
- Gunakan date ranges untuk statistikRange() untuk membatasi dataset
- Query per-hari akan lebih cepat daripada all-time aggregations

---

## 5. Database Queries Generated

### Sample Query Structures

**Total Per Hari:**

```sql
SELECT tanggal_produksi, SUM(jumlah_produksi) as total_produksi, COUNT(DISTINCT id_karyawan) as jumlah_karyawan
FROM tim_produksi
GROUP BY tanggal_produksi
ORDER BY tanggal_produksi DESC
```

**Total Per Karyawan:**

```sql
SELECT id_karyawan, SUM(jumlah_produksi) as total_produksi, COUNT(DISTINCT tanggal_produksi) as hari_bekerja
FROM tim_produksi
GROUP BY id_karyawan
ORDER BY total_produksi DESC
```

**Statistik Range:**

```sql
SELECT
    tanggal_produksi,
    COUNT(DISTINCT id_karyawan) as jumlah_karyawan,
    COUNT(DISTINCT id_produksi) as jumlah_produk,
    SUM(jumlah_produksi) as total_produksi,
    AVG(jumlah_produksi) as rata_rata,
    MIN(jumlah_produksi) as min,
    MAX(jumlah_produksi) as max
FROM tim_produksi
WHERE tanggal_produksi BETWEEN ? AND ?
GROUP BY tanggal_produksi
```

---

## 6. Implementation Notes

### Indexes Used

- `tim_produksi.id_produksi` - untuk filter by produksi
- `tim_produksi.id_karyawan` - untuk filter by karyawan
- `tim_produksi.tanggal_produksi` - untuk date-based queries

### Relation Loading Strategy

- Methods menggunakan eager loading (`.with()`) untuk detail data
- Menghindari N+1 query problems pada looped collections

### Query Optimization

- GROUP BY queries menggunakan proper indexes
- Distinct() calls untuk accurate counting
- orderBy() untuk consistent result ordering

---

## 7. Usage Examples

### Dashboard Reporting

```php
// Dashboard showing all daily production stats
$dailyStats = TimProduksi::statistikRange(
    now()->startOfMonth(),
    now()->endOfMonth()
);
// Loop through untuk display charts
```

### Employee Performance Review

```php
$employee = Karyawan::find($id);
$monthlyPerf = $employee->getPerformaBulan('2026-01');
$topProducts = $employee->getProdukYangDikerjakan();
$stats = $employee->getStatistikKontribusi();
// Compile untuk review report
```

### Production Team Analysis

```php
$production = Produksi::find($id);
$teamStats = $production->getStatistikTimProduksi();
$topPerformers = $production->getTopKaryawan(10);
$dailyBreakdown = $production->getProduksiPerHari();
// Analyze team performance
```

### Monthly Report Generation

```php
foreach (Karyawan::all() as $employee) {
    $report = [
        'employee' => $employee->nama_karyawan,
        'stats' => $employee->getStatistikKontribusi(),
        'monthly' => $employee->getPerformaBulan('2026-01'),
    ];
    // Generate PDF/export
}
```

---

## 8. No Configuration Required

- Tidak perlu environment variables
- Tidak perlu setting di .env
- Tidak perlu service provider registration
- Langsung bisa digunakan setelah include models

---

**Status:** ✓ Production Ready  
**Last Updated:** 2026-01-31  
**Query Type:** Read-Only (SUM, GROUP BY, COUNT, AVG, MIN, MAX)
