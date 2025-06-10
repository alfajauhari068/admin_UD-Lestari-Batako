<!-- filepath: resources/views/produk/profil_produk.blade.php -->
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> <!-- Jika ada file CSS kustom -->
</head>
@extends('layouts.navbar')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="fw-bold mb-0">Detail Produk</h2>
                </div>
                <div class="card-body">
                    <!-- Gambar Produk -->
                    @if($KurirData->gambar_produk)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $KurirData->gambar_produk) }}" alt="Gambar Produk" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                        </div>
                    @else
                        <div class="text-center mb-4">
                            <img src="https://via.placeholder.com/600x400?text=Tidak+Ada+Gambar" alt="Tidak Ada Gambar" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                        </div>
                    @endif

                    <!-- Informasi Produk -->
                    <h4 class="card-title fw-bold text-center text-primary">{{ $KurirData->nama_produk }}</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Harga:</strong> Rp{{ number_format($KurirData->harga_satuan, 0, ',', '.') }}</p>
                            <p><strong>Stok Tersedia:</strong> {{ $KurirData->stok_tersedia }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dibuat pada:</strong> {{ $KurirData->created_at ? $KurirData->created_at->format('d M Y H:i') : '-' }}</p>
                            <p><strong>Diupdate pada:</strong> {{ $KurirData->updated_at ? $KurirData->updated_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary me-2">Kembali</a>
                    <a href="{{ route('produk.edit', $KurirData->id_produk ?? $KurirData->id) }}" class="btn btn-primary">Edit Produk</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection