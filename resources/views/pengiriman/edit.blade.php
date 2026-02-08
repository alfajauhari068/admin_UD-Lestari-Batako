@extends('layouts.app')

@section('title', 'Edit Pengiriman')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Edit Pengiriman',
        'subtitle' => 'Edit informasi pengiriman',
        'breadcrumbs' => [
            ['label' => 'Pengiriman', 'url' => route('pengiriman.index')],
            ['label' => 'Edit']
        ]
    ])
    @endcomponent

    @component('components.card', ['title' => 'Edit Pengiriman'])
        <form action="{{ route('pengiriman.update', $pengiriman->id_pengiriman) }}" method="POST">
            @csrf
            @method('PUT')
            @include('components.errors')

            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Pesanan',
                        'name' => 'id_pesanan',
                        'type' => 'select',
                        'options' => $pesanan->pluck('id_pesanan', 'id_pesanan')->toArray(),
                        'required' => true,
                        'value' => old('id_pesanan', $pengiriman->id_pesanan)
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Tanggal Pengiriman',
                        'name' => 'tanggal_pengiriman',
                        'type' => 'date',
                        'required' => true,
                        'value' => old('tanggal_pengiriman', $pengiriman->tanggal_pengiriman->format('Y-m-d'))
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Driver',
                        'name' => 'driver',
                        'type' => 'text',
                        'value' => old('driver', $pengiriman->driver)
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Status',
                        'name' => 'status',
                        'type' => 'select',
                        'options' => ['pending' => 'Pending', 'dalam_perjalanan' => 'Dalam Perjalanan', 'terkirim' => 'Terkirim', 'dibatalkan' => 'Dibatalkan'],
                        'required' => true,
                        'value' => old('status', $pengiriman->status)
                    ])
                </div>
                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Catatan',
                        'name' => 'catatan',
                        'textarea' => true,
                        'rows' => 3,
                        'value' => old('catatan', $pengiriman->catatan)
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
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
