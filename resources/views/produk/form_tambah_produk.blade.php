@extends('layouts.app')

@section('content')
<div class="page-container p-fluid">

        

        {{-- Panel Form (card layout like pelanggan) --}}
        <div class="container">
            <div class="">
                <div class="mt-5">
                    @component('components.breadcrumb')
                        @slot('breadcrumbs', [
                            ['name' => 'Produk', 'url' => route('produk.index')],
                            ['name' => 'Tambah Produk', 'url' => route('produk.create')]
                        ])
                    @endcomponent
                </div>

                <h2 class="mb-4 mt-2 fw-bold text-primary">Tambah Produk</h2>
                <div class="card custom-card p-5">
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

                        <h5 class="fw-bold text-primary mb-5">Informasi Produk</h5>

                        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nama --}}
                            <div class="mb-4">
                                <label for="nama_produk" class="form-label">Nama Produk *</label>
                                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk"
                                       value="{{ old('nama_produk') }}" required
                                       placeholder="Masukkan nama produk">
                                @error('nama_produk')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Gambar --}}
                            <div class="mb-4">
                                <label for="gambar_produk" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control @error('gambar_produk') is-invalid @enderror" id="gambar_produk" name="gambar_produk">
                                @error('gambar_produk')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div class="mb-4">
                                <label for="harga_satuan" class="form-label">Harga</label>
                                <input type="number" class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan" name="harga_satuan"
                                       value="{{ old('harga_satuan') }}"
                                       placeholder="Masukkan harga">
                                @error('harga_satuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Stok --}}
                            <div class="mb-4">
                                <label for="stok_tersedia" class="form-label">Stok Tersedia</label>
                                <input type="number" class="form-control @error('stok_tersedia') is-invalid @enderror" id="stok_tersedia" name="stok_tersedia"
                                       value="{{ old('stok_tersedia') }}"
                                       placeholder="Masukkan stok">
                                @error('stok_tersedia')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-4">
                                <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                                <textarea class="form-control form-textarea @error('deskripsi_produk') is-invalid @enderror" id="deskripsi_produk" name="deskripsi_produk" rows="4"
                                          placeholder="Deskripsi produk">{{ old('deskripsi_produk') }}</textarea>
                                @error('deskripsi_produk')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                                <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-secondary-custom">
                                    <i class="bi bi-arrow-left-circle me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary btn-primary-custom">
                                    <i class="bi bi-save2 me-2"></i>Simpan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="app-footer mt-4">
            &copy; {{ date('Y') }} UD. Lestari Batako
        </footer>

</div>

{{-- Tooltip Bootstrap --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });
</script>

@endsection