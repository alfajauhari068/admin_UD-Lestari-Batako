@extends('layouts.app')

@section('title', 'Buat Produksi')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Buat Produksi',
        'subtitle' => 'Tambah produksi baru',
        'breadcrumbs' => [
            ['label' => 'Produksi', 'url' => route('produksi.index')],
            ['label' => 'Baru']
        ]
    ])
    @endcomponent

    @component('components.card', ['title' => 'Form Produksi'])
        <form action="{{ route('produksi.store') }}" method="POST">
            @csrf
            @include('components.errors')

            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Produk',
                        'name' => 'id_produk',
                        'type' => 'select',
                        'options' => $produk->pluck('nama_produk', 'id_produk')->toArray(),
                        'required' => true
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Tanggal Produksi',
                        'name' => 'tanggal_produksi',
                        'type' => 'date',
                        'required' => true,
                        'value' => now()->format('Y-m-d')
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Jumlah',
                        'name' => 'jumlah',
                        'type' => 'number',
                        'required' => true,
                        'placeholder' => 'Jumlah produksi'
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Status',
                        'name' => 'status',
                        'type' => 'select',
                        'options' => ['berjalan' => 'Berjalan', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'],
                        'required' => true,
                        'value' => 'berjalan'
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('produksi.index') }}" class="btn btn-secondary">
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
