<!-- filepath: d:\KULIAH\Semester4\Pemrograman FrameWork\ud_lestari-batako\resources\views\produk\form_edit_produk.blade.php -->
@extends('layouts.app')

@section('content')
<div class="page-container p-fluid">
         <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produk', 'url' => route('produk.index')],
                    ['name' => 'Edit Produks',]
                ])
            @endcomponent
    </div>
        <h4 class="mt-4 fw-bold text-primary">Edit Produk</h4>
        <form 
        action="{{ route('produk.update', $produk->id_produk ?? $produk->id) }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="card custom-card p-4 p-md-5 rounded-4 mx-auto max-w-900"
        >

    @csrf
    @method('PUT')

    <h4 class="fw-bold text-primary mb-5 text-center">Edit Produk</h4>

    {{-- Nama Produk --}}
    <div class="mb-4">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" id="nama_produk" name="nama_produk"
                class="form-control @error('nama_produk') is-invalid @enderror"
                value="{{ old('nama_produk', $produk->nama_produk) }}"
                placeholder="Masukkan nama produk" required>
        @error('nama_produk')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    {{-- Gambar Produk --}}
    <div class="mb-4">
        <label for="gambar_produk" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Gambar Produk</label>
        @if($produk->gambar_produk)
            <div class="mb-3">
                 <img src="{{ asset('..\storage\gambar_produk' . $produk->gambar_produk) }}" alt="Gambar Produk"
                     width="150" class="img-thumbnail shadow-sm rounded-lg">
            </div>
        @endif
        <input type="file" id="gambar_produk" name="gambar_produk"
               class="form-control @error('gambar_produk') is-invalid @enderror" accept="image/*">
        @error('gambar_produk')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    {{-- Harga Satuan --}}
    <div class="mb-4">
        <label for="harga_satuan" class="form-label">Harga Satuan</label>
        <input type="number" step="0.01" id="harga_satuan" name="harga_satuan"
               class="form-control @error('harga_satuan') is-invalid @enderror"
               value="{{ old('harga_satuan', $produk->harga_satuan) }}"
               placeholder="Masukkan harga satuan" required>
        @error('harga_satuan')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    {{-- Deskripsi Produk --}}
    <div class="mb-4">
        <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
        <textarea id="deskripsi_produk" name="deskripsi_produk"
                  class="form-control form-textarea @error('deskripsi_produk') is-invalid @enderror"
                  rows="4"
                  placeholder="Masukkan deskripsi produk">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
        @error('deskripsi_produk')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    {{-- Stok Tersedia --}}
    <div class="mb-4">
        <label for="stok_tersedia" class="form-label">Stok Tersedia</label>
        <input type="number" id="stok_tersedia" name="stok_tersedia"
               class="form-control @error('stok_tersedia') is-invalid @enderror"
               value="{{ old('stok_tersedia', $produk->stok_tersedia) }}"
               placeholder="Masukkan jumlah stok" required>
        @error('stok_tersedia')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    {{-- Tombol --}}
    <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
        <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-secondary-custom">
            <i class="bi bi-arrow-left-circle me-2"></i>Batal
        </a>
        <button type="submit" class="btn btn-primary btn-primary-custom">
            <i class="bi bi-save2 me-2"></i>Update
        </button>
    </div>
</form>

    </div>
@endsection