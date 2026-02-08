@extends('layouts.app')

@section('title', 'Edit Produksi')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Edit Produksi',
        'subtitle' => 'Edit informasi produksi',
        'breadcrumbs' => [
            ['label' => 'Produksi', 'url' => route('produksi.index')],
            ['label' => 'Edit']
        ]
    ])
    @endcomponent

    @component('components.card', ['title' => 'Edit Produksi'])
        <form action="{{ route('produksi.update', $produksi->id_produksi) }}" method="POST">
            @csrf
            @method('PUT')
            @include('components.errors')

            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Produk',
                        'name' => 'id_produk',
                        'type' => 'select',
                        'options' => $produk->pluck('nama_produk', 'id_produk')->toArray(),
                        'required' => true,
                        'value' => old('id_produk', $produksi->id_produk)
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Tanggal Produksi',
                        'name' => 'tanggal_produksi',
                        'type' => 'date',
                        'required' => true,
                        'value' => old('tanggal_produksi', $produksi->tanggal_produksi?->format('Y-m-d'))
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Jumlah',
                        'name' => 'jumlah',
                        'type' => 'number',
                        'required' => true,
                        'value' => old('jumlah', $produksi->jumlah)
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Status',
                        'name' => 'status',
                        'type' => 'select',
                        'options' => ['berjalan' => 'Berjalan', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'],
                        'required' => true,
                        'value' => old('status', $produksi->status)
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('produksi.index') }}" class="btn btn-secondary">
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
