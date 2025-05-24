<!-- filepath: d:\KULIAH\Semester4\Interaksi Manusia dan Komputer\tugas-3\ud_lestari-batako\resources\views\produk\profil_produk.blade.php -->
@extends('layouts.navbar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">Detail Produk</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="card-title fw-bold">{{ $KurirData->nama_produk }}</h4>
            <p class="card-text">
                <strong>Harga:</strong> Rp{{ number_format($KurirData->harga_satuan, 0, ',', '.') }}<br>
                <strong>Stok Tersedia:</strong> {{ $KurirData->stok_tersedia }}<br>
                <strong>Dibuat pada:</strong> {{ $KurirData->created_at ? $KurirData->created_at->format('d M Y H:i') : '-' }}<br>
                <strong>Diupdate pada:</strong> {{ $KurirData->updated_at ? $KurirData->updated_at->format('d M Y H:i') : '-' }}
            </p>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection