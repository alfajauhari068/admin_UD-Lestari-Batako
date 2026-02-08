@extends('layouts.app')

@section('title', 'Buat Pesanan')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Buat Pesanan',
        'subtitle' => 'Tambah pesanan baru',
        'breadcrumbs' => [
            ['label' => 'Pesanan', 'url' => route('pesanan.index')],
            ['label' => 'Baru']
        ]
    ])
    @endcomponent

    {{-- Form Card --}}
    @component('components.card', ['title' => 'Form Pesanan'])
        <form action="{{ route('pesanan.store') }}" method="POST">
            @csrf

            {{-- Validation Errors --}}
            @include('components.errors')

            {{-- Form Fields --}}
            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Pelanggan',
                        'name' => 'id_pelanggan',
                        'type' => 'select',
                        'options' => $pelanggan->pluck('nama', 'id_pelanggan')->toArray(),
                        'required' => true
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Tanggal Pesanan',
                        'name' => 'tanggal_pesanan',
                        'type' => 'date',
                        'required' => true,
                        'value' => now()->format('Y-m-d')
                    ])
                </div>

                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Catatan',
                        'name' => 'catatan',
                        'textarea' => true,
                        'rows' => 3,
                        'placeholder' => 'Catatan pesanan...'
                    ])
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
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
