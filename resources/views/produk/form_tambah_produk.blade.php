<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> <!-- Jika ada file CSS kustom -->
    <title>Tambah Produk</title>
</head>
<body>
@extends('layouts.navbar')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar') <!-- Sidebar -->
    <div class="container p-5 mt-4" style="background: linear-gradient(to right, #f8f9fa, #e9ecef); min-height: 100vh;margin-left: 250px;">
    <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produk', 'url' => route('produk.index')],
                    ['name' => 'Tambah Produks', 'url' => route('produk.create')]
                ])
            @endcomponent
    </div>
        <h2 class="mt-4 fw-bold text-primary">Tambah Produk</h2>
        <form class="ms-5" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Input Nama Produk -->
            <div class="mb-3">
                <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" placeholder="Masukkan nama produk" required>
                @error('nama_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Gambar Produk -->
            <div class="mb-3">
                <label for="gambar_produk" class="form-label fw-bold">Gambar Produk</label>
                <input type="file" name="gambar_produk" class="form-control @error('gambar_produk') is-invalid @enderror" id="gambar_produk" required>
                @error('gambar_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Harga -->
            <div class="mb-3">
                <label for="harga_satuan" class="form-label fw-bold">Harga</label>
                <input type="number" class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan') }}" placeholder="Masukkan harga produk" required>
                @error('harga_satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Stok -->
            <div class="mb-3">
                <label for="stok_tersedia" class="form-label fw-bold">Stok</label>
                <input type="number" class="form-control @error('stok_tersedia') is-invalid @enderror" id="stok_tersedia" name="stok_tersedia" value="{{ old('stok_tersedia') }}" placeholder="Masukkan jumlah stok" required>
                @error('stok_tersedia')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Deskripsi Produk -->
            <div class="mb-3">
                <label for="deskripsi_produk" class="form-label fw-bold">Deskripsi Produk</label>
                <textarea class="form-control @error('deskripsi_produk') is-invalid @enderror" id="deskripsi_produk" name="deskripsi_produk" rows="4" placeholder="Masukkan deskripsi produk">{{ old('deskripsi_produk') }}</textarea>
                @error('deskripsi_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Simpan dan Batal -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
</body>
</html>