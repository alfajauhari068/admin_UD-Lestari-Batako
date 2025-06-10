@extends('layouts.navbar')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar') <!-- Sidebar -->
    <div class="container-fluid py-5" style="margin-left: 250px; padding-top: 80px; background:rgba(252, 252, 252, 0.61); min-height: 100vh;">
        <!-- Header / Welcome Banner -->
        <div class="text-center mb-5 p-4" style="background:rgba(242, 247, 247, 0.34); box-shadow: 0 2px 6px rgba(0, 0, 0, 0.13);">
            <h1 class="fw-bold text-primary fs-3">Selamat Datang di Dashboard Admin</h1>
            <p class="text-muted fs-6">UD. Lestari Batako — Kuat di setiap sudut, indah di manapun Anda melihat</p>
            <p><strong><u>Tanggal:</strong> {{ date('d M Y') }} </u>| <strong>Admin:</strong> {{ Auth::user()->name ?? 'Admin' }}</p>
        </div>

        <!-- Ringkasan Data Penting -->
        <div class="row g-4 mb-5">
            <!-- Total Produk -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center" style="background: linear-gradient(135deg, #2196f3, #64b5f6); border-radius: 10px; color: #fff;">
                    <div class="card-body p-4">
                        <i class="bi bi-box-seam mb-3" style="font-size: 40px;"></i>
                        <h5 class="card-title fw-bold">Total Produk</h5>
                        <p class="fs-5">{{ $totalProduk }} Jenis Produk</p>
                    </div>
                </div>
            </div>

            <!-- Stok Hampir Habis -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center" style="background: linear-gradient(135deg, #ff9800, #ffc107); border-radius: 10px; color: #fff;">
                    <div class="card-body p-4">
                        <i class="bi bi-exclamation-triangle-fill mb-3" style="font-size: 40px;"></i>
                        <h5 class="card-title fw-bold">Stok Hampir Habis</h5>
                        <p class="fs-5">{{ $produkKritis }} Produk Kritis</p>
                    </div>
                </div>
            </div>

            <!-- Pesanan Masuk Hari Ini -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center" style="background: linear-gradient(135deg, #4caf50, #81c784); border-radius: 10px; color: #fff;">
                    <div class="card-body p-4">
                        <i class="bi bi-cart-check-fill mb-3" style="font-size: 40px;"></i>
                        <h5 class="card-title fw-bold">Pesanan Masuk Hari Ini</h5>
                        <p class="fs-5">{{ $pesananHariIni }} Pesanan Baru</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Pesanan Terbaru -->
        <div class="mb-5">
            <h3 class="fw-bold text-primary">Daftar Pesanan Terbaru</h3>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th><center>No<center></th>
                            <th><center>ID Pesanan<center></th>
                            <th><center>Pelanggan<center></th>
                            <th><center>Produk<center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesananTerbaru as $pesanan)
                        <tr>
                            <td><center>{{ $loop->iteration }}<center></td>
                            <td><center>{{ $pesanan->id_pesanan }}<center></td>
                            <td><center>{{ $pesanan->pelanggan->nama ?? 'Tidak Diketahui' }}<center></td>
                            <td><center>
                                @foreach($pesanan->detailPesanan as $detail)
                                    {{ $detail->id_produk->nama_produk ?? 'Tidak Diketahui' }}<br>
                                @endforeach
                            <center></td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pesanan terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('pesanan.index') }}" class="btn btn-primary mt-3">Lihat Semua Pesanan</a>
        </div>

        <!-- Informasi Perusahaan -->
        <footer class="text-center mt-5">
            <p class="fw-bold">Nama Usaha: UD. Lestari Batako</p>
            <p>Alamat: Jl. R.A.Kartini Bakalan Sumbergayam Durenan Trenggalek rt:05 rw:03</p>
            <p>No. Telp/WA: 081553675279 | Email: info@lestaribatako.co.id</p>
            <p>Instagram: @lestaribatako</p>
        </footer>
    </div>
</div>
@endsection
