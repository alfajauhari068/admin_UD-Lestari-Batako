@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
{{-- Welcome Section --}}
<div class="container-fluid py-4">
    @component('components.page-header', [
        'title' => 'UD. Lestari Batako',
        'subtitle' => 'Sistem Manajemen Produksi Batako',
        'breadcrumbs' => [
            ['label' => 'Beranda']
        ]
    ])
    @endcomponent

    {{-- Welcome Card --}}
    @component('components.card', ['title' => 'Selamat Datang di Sistem'])
        <div class="text-center py-4">
            <div class="mb-4">
                <img src="{{ asset('assets/Logo-LB.jpg') }}" alt="Logo" class="img-fluid" style="max-height: 120px;">
            </div>
            <h4 class="mb-3">Sistem Manajemen Produksi Batako</h4>
            <p class="text-muted mb-4">
                Kelola produk, pesanan, pelanggan, pengiriman, dan tim produksi dengan mudah.
            </p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-speedometer2 me-2"></i>Masuk ke Dashboard
                </a>
            @else
                @if(Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </a>
                @endif
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-primary ms-2">
                        <i class="bi bi-person-plus me-2"></i>Daftar
                    </a>
                @endif
            @endauth
        </div>
    @endcomponent

    {{-- Quick Info Cards --}}
    <div class="row mt-4">
        <div class="col-md-4 mb-3 mb-md-0">
            @component('components.card')
                <div class="text-center py-4">
                    <i class="bi bi-box-seam fs-1 text-primary"></i>
                    <h5 class="mt-3 mb-2">Produk Berkualitas</h5>
                    <p class="text-muted small mb-0">Batako berkualitas tinggi dengan berbagai ukuran</p>
                </div>
            @endcomponent
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            @component('components.card')
                <div class="text-center py-4">
                    <i class="bi bi-gear-wide-connected fs-1 text-success"></i>
                    <h5 class="mt-3 mb-2">Produksi Efisien</h5>
                    <p class="text-muted small mb-0">Proses produksi yang terstruktur dan efisien</p>
                </div>
            @endcomponent
        </div>
        <div class="col-md-4">
            @component('components.card')
                <div class="text-center py-4">
                    <i class="bi bi-truck fs-1 text-info"></i>
                    <h5 class="mt-3 mb-2">Pengiriman Tepat Waktu</h5>
Pengiriman T                    <p class="text-muted small mb-0">Pengiriman ke seluruh wilayah</p>
                </div>
            @endcomponent
        </div>
    </div>
</div>
@endsection
