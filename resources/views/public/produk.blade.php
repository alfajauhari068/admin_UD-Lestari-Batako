@extends('layouts.app')

@section('title', 'Shop Listing')

@section('content')
@include('partials.navbar')
    <style>
    .shop-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .shop-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
    }

    .shop-image {
        height: 250px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }

    .shop-price {
        color: #dc3545;
        font-weight: 600;
        font-size: 1rem;
    }

    .shop-stock {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Shop Listing</h1>
        <p class="text-muted">Temukan produk interior terbaik untuk kebutuhan Anda</p>
    </div>

    <div class="row">
        @foreach ($KurirData as $produks)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card shop-card h-100">
                    <img src="{{ asset('storage/' . $produks->gambar_produk) }}"
                         class="card-img-top shop-image"
                         alt="{{ $produks->nama_produk }}">

                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title fw-semibold">{{ $produks->nama_produk }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($produks->deskripsi_produk, 100) }}</p>
                        </div>

                        <div class="mt-3">
                            <p class="shop-price mb-1">Rp{{ number_format($produks->harga_satuan, 0, ',', '.') }}</p>
                            <p class="shop-stock mb-2">Stok tersedia: {{ $produks->stok_tersedia }}</p>
                            <a href="#" class="btn btn-outline-danger btn-sm w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
</div>
@endsection


