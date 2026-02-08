@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Tambah Produk',
        'subtitle' => 'Tambah produk baru ke UD. Lestari Batako',
        'breadcrumbs' => [
            ['label' => 'Produk', 'url' => route('produk.index')],
            ['label' => 'Tambah']
        ]
    ])
    @endcomponent

    {{-- Form Card --}}
    @component('components.card', ['title' => 'Informasi Produk'])
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Validation Errors --}}
            @include('components.errors')

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Form Fields --}}
            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Nama Produk',
                        'name' => 'nama_produk',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Masukkan nama produk'
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Gambar Produk',
                        'name' => 'gambar_produk',
                        'type' => 'file',
                        'help' => 'Format: JPG, PNG, GIF. Maksimal 2MB'
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Harga Satuan',
                        'name' => 'harga_satuan',
                        'type' => 'number',
                        'required' => true,
                        'placeholder' => 'Masukkan harga'
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Stok Tersedia',
                        'name' => 'stok_tersedia',
                        'type' => 'number',
                        'required' => true,
                        'placeholder' => 'Masukkan jumlah stok'
                    ])
                </div>

                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Deskripsi Produk',
                        'name' => 'deskripsi_produk',
                        'textarea' => true,
                        'rows' => 4,
                        'placeholder' => 'Deskripsi produk...'
                    ])
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save2 me-1"></i>Simpan
                </button>
            </div>
        </form>
    @endcomponent

</div>
@endsection
