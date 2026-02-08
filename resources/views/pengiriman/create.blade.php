@extends('layouts.app')

@section('title', 'Buat Pengiriman')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Buat Pengiriman',
        'subtitle' => 'Tambah pengiriman baru',
        'breadcrumbs' => [
            ['label' => 'Pengiriman', 'url' => route('pengiriman.index')],
            ['label' => 'Baru']
        ]
    ])
    @endcomponent

    @component('components.card', ['title' => 'Form Pengiriman'])
        <form action="{{ route('pengiriman.store') }}" method="POST">
            @csrf
            @include('components.errors')

            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Pesanan',
                        'name' => 'id_pesanan',
                        'type' => 'select',
                        'options' => $pesanan->pluck('id_pesanan', 'id_pesanan')->toArray(),
                        'required' => true
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Tanggal Pengiriman',
                        'name' => 'tanggal_pengiriman',
                        'type' => 'date',
                        'required' => true,
                        'value' => now()->format('Y-m-d')
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Driver',
                        'name' => 'driver',
                        'type' => 'text',
                        'placeholder' => 'Nama driver'
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Status',
                        'name' => 'status',
                        'type' => 'select',
                        'options' => ['pending' => 'Pending', 'dalam_perjalanan' => 'Dalam Perjalanan', 'terkirim' => 'Terkirim', 'dibatalkan' => 'Dibatalkan'],
                        'required' => true,
                        'value' => 'pending'
                    ])
                </div>
                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Catatan',
                        'name' => 'catatan',
                        'textarea' => true,
                        'rows' => 3
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
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
