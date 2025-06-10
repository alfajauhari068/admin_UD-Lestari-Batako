<!-- filepath: d:\KULIAH\Semester4\Pemrograman FrameWork\ud_lestari-batako\resources\views\produk\form_edit_produk.blade.php -->
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> <!-- Jika ada file CSS kustom -->
</head>
@extends('layouts.navbar')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar') <!-- Sidebar -->
    <div class="container py-4 p-5 mt-5 align-item-center" style="background: linear-gradient(to right, #f8f9fa, #e9ecef); min-height: 100vh;margin-left: 250px;"> 
         <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produk', 'url' => route('produk.index')],
                    ['name' => 'Edit Produks',]
                ])
            @endcomponent
    </div>
        <h4 class="mt-4 fw-bold text-primary">Edit Produk</h4>
        <form class="ms-5" action="{{ route('produk.update', $produk->id_produk ?? $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Input Nama Produk -->
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" placeholder="Masukkan nama produk" required>
                @error('nama_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Gambar Produk -->
            <div class="mb-3">
                <label for="gambar_produk" class="form-label fw-bold">Gambar Produk</label>
                @if($produk->gambar_produk)
                    <div class="mb-2">
                        <img src="{{ asset('/storage/gambar_produk/' . $produk->gambar_produk) }}" alt="Gambar Produk" width="150" class="img-thumbnail">
                    </div>
                @endif
                <input type="file" class="form-control @error('gambar_produk') is-invalid @enderror" id="gambar_produk" name="gambar_produk" accept="image/*">
                @error('gambar_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Harga Satuan -->
            <div class="mb-3">
                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                <input type="number" step="0.01" class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan', $produk->harga_satuan) }}" placeholder="Masukkan harga satuan" required>
                @error('harga_satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Deskripsi Produk -->
            <div class="mb-3">
                <label for="deskripsi_produk" class="form-label fw-bold">Deskripsi Produk</label>
                <textarea class="form-control @error('deskripsi_produk') is-invalid @enderror" id="deskripsi_produk" name="deskripsi_produk" rows="4" placeholder="Masukkan deskripsi produk">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
                @error('deskripsi_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Stok Tersedia -->
            <div class="mb-3">
                <label for="stok_tersedia" class="form-label">Stok Tersedia</label>
                <input type="number" class="form-control @error('stok_tersedia') is-invalid @enderror" id="stok_tersedia" name="stok_tersedia" value="{{ old('stok_tersedia', $produk->stok_tersedia) }}" placeholder="Masukkan jumlah stok" required>
                @error('stok_tersedia')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Update dan Batal -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection