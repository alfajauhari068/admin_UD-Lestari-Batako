<!-- filepath: resources/views/dashboard.blade.php -->
@extends('layouts.navbar')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-primary">Dashboard UD Lestari Batako</h1>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="bi bi-box-seam display-4 text-primary"></i>
                    </div>
                    <h5 class="card-title mb-2">Produk</h5>
                    <p class="text-muted small mb-3">Kelola data produk batako, paving, dll.</p>
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-primary btn-sm">Lihat Produk</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="bi bi-people-fill display-4 text-success"></i>
                    </div>
                    <h5 class="card-title mb-2">Pelanggan</h5>
                    <p class="text-muted small mb-3">Data pelanggan dan relasi bisnis.</p>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-success btn-sm">Lihat Pelanggan</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="bi bi-cart-check-fill display-4 text-warning"></i>
                    </div>
                    <h5 class="card-title mb-2">Pesanan</h5>
                    <p class="text-muted small mb-3">Kelola pesanan masuk dan riwayat transaksi.</p>
                    <a href="{{ route('pesanan.index') }}" class="btn btn-outline-warning btn-sm">Lihat Pesanan</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="bi bi-truck display-4 text-danger"></i>
                    </div>
                    <h5 class="card-title mb-2">Pengiriman</h5>
                    <p class="text-muted small mb-3">Pantau status dan jadwal pengiriman.</p>
                    <a href="{{ route('pengiriman.index') }}" class="btn btn-outline-danger btn-sm">Lihat Pengiriman</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection