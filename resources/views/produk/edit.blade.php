@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Edit Produk',
        'subtitle' => 'Edit informasi produk',
        'breadcrumbs' => [
            ['label' => 'Produk', 'url' => route('produk.index')],
            ['label' => 'Edit']
        ]
    ])
    @endcomponent

    {{-- Form Card --}}
    @component('components.card', ['title' => 'Edit Produk: ' . ($produk->nama_produk ?? '')])
        <form action="{{ route('produk.update', $produk->id_produk ?? $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Validation Errors --}}
            @include('components.errors')

            {{-- Form Fields --}}
            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Nama Produk',
                        'name' => 'nama_produk',
                        'type' => 'text',
                        'required' => true,
                        'value' => old('nama_produk', $produk->nama_produk ?? ''),
                        'placeholder' => 'Masukkan nama produk'
                    ])
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Gambar Produk</label>
                        @if($produk->gambar_produk)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $produk->gambar_produk) }}" alt="Gambar Produk"
                                     width="150" class="img-thumbnail rounded">
                            </div>
                        @endif
                        <input type="file" name="gambar_produk" class="form-control @error('gambar_produk') is-invalid @enderror" accept="image/*">
                        @error('gambar_produk')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Harga Satuan',
                        'name' => 'harga_satuan',
                        'type' => 'number',
                        'required' => true,
                        'value' => old('harga_satuan', $produk->harga_satuan ?? ''),
                        'placeholder' => 'Masukkan harga satuan'
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Stok Tersedia',
                        'name' => 'stok_tersedia',
                        'type' => 'number',
                        'required' => true,
                        'value' => old('stok_tersedia', $produk->stok_tersedia ?? ''),
                        'placeholder' => 'Masukkan jumlah stok'
                    ])
                </div>

                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Deskripsi Produk',
                        'name' => 'deskripsi_produk',
                        'textarea' => true,
                        'rows' => 4,
                        'value' => old('deskripsi_produk', $produk->deskripsi_produk ?? ''),
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
                    <i class="bi bi-save2 me-1"></i>Update
                </button>
            </div>
        </form>
    @endcomponent

</div>
@endsection
