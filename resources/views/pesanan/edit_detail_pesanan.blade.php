<!-- filepath: resources/views/pesanan/edit_detail_pesanan.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4 p-5">
    <h2 class="mb-5 pt-5 fw-bold text-primary text-center">Edit Detail Pesanan</h2>
    <div class="card custom-card mx-auto">
        <div class="card-body p-0">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('detail_pesanan.update', $detailPesanan->id_detail_pesanan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Pilihan Produk --}}
                <div class="mb-4">
                        <label for="id_produk" class="form-label fw-semibold">Produk *</label>
                        <select class="form-select form-control @error('id_produk') is-invalid @enderror" id="id_produk" name="id_produk" required>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id_produk }}"
                                    {{ old('id_produk', $detailPesanan->id_produk) == $produk->id_produk ? 'selected' : '' }}>
                                {{ $produk->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_produk')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jumlah Produk --}}
                <div class="mb-4">
                          <label for="jumlah" class="form-label fw-semibold">Jumlah *</label>
                          <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                              id="jumlah" name="jumlah" value="{{ old('jumlah', $detailPesanan->jumlah) }}" required>
                    @error('jumlah')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                    <a href="{{ route('pesanan.detail', $detailPesanan->id_pesanan) }}" class="btn btn-secondary-custom">
                        <i class="bi bi-arrow-left-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection