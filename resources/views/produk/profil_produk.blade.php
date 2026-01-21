@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 100vh;">

    {{-- Breadcrumb --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h2 class="fw-bold mb-0">Detail Produk</h2>
                </div>

                <div class="card-body px-4 py-5">
                    {{-- Gambar Produk --}}
                    <div class="text-center mb-4">
                        <img src="{{ $KurirData->gambar_produk ? asset('storage/' . $KurirData->gambar_produk) : 'https://via.placeholder.com/600x400?text=Tidak+Ada+Gambar' }}"
                             alt="Gambar Produk"
                             class="img-fluid rounded-3 shadow-sm"
                             style="max-width: 100%; height: auto;">
                    </div>

                    {{-- Informasi Produk --}}
                    <h4 class="card-title fw-bold text-center text-primary mb-4">
                        {{ $KurirData->nama_produk }}
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-2"><strong>Harga:</strong></p>
                            <p class="text-muted">Rp{{ number_format($KurirData->harga_satuan, 0, ',', '.') }}</p>
                            <p class="mb-2"><strong>Stok Tersedia:</strong></p>
                            <p class="text-muted">{{ $KurirData->stok_tersedia }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-2"><strong>Dibuat pada:</strong></p>
                            <p class="text-muted">{{ $KurirData->created_at ? $KurirData->created_at->format('d M Y H:i') : '-' }}</p>
                            <p class="mb-2"><strong>Diupdate pada:</strong></p>
                            <p class="text-muted">{{ $KurirData->updated_at ? $KurirData->updated_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light border-top text-center py-3">
                    <a href="{{ route('produk.index') }}"
                       class="btn btn-outline-secondary me-2 d-inline-flex align-items-center gap-1">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('produk.edit', $KurirData->id_produk ?? $KurirData->id) }}"
                       class="btn btn-primary d-inline-flex align-items-center gap-1">
                        <i class="bi bi-pencil-square"></i> Edit Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection