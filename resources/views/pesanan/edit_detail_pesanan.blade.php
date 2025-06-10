<!-- filepath: resources/views/pesanan/edit_detail_pesanan.blade.php -->
@extends('layouts.navbar')

@section('content')
<div class="container py-4 p-5">
    <h2 class="mb-4 pt-5 fw-bold text-primary text-center">Edit Detail Pesanan</h2>
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 500px; border-radius: 12px;">
        <div class="card-body p-4">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="bi bi-check-circle-fill text-success me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill text-danger me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('detail_pesanan.update', $detailPesanan->id_detail_pesanan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Pilihan Produk --}}
                <div class="mb-3">
                    <label for="id_produk" class="form-label fw-semibold">Produk</label>
                    <select class="form-select" id="id_produk" name="id_produk" required>
                        @foreach($produks as $produk)
                        <option value="{{ $produk->id_produk }}" 
                                {{ $produk->id_produk == $detailPesanan->id_produk ? 'selected' : '' }}>
                            {{ $produk->nama_produk }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah Produk --}}
                <div class="mb-3">
                    <label for="jumlah" class="form-label fw-semibold">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $detailPesanan->jumlah }}" required>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                    <a href="{{ route('pesanan.detail', $detailPesanan->id_pesanan) }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection