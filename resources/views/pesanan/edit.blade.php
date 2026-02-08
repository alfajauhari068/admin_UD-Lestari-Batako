@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Edit Pesanan',
        'subtitle' => 'Edit pesanan',
        'breadcrumbs' => [
            ['label' => 'Pesanan', 'url' => route('pesanan.index')],
            ['label' => 'Edit']
        ]
    ])
    @endcomponent

    {{-- Form Card --}}
    @component('components.card', ['title' => 'Edit Pesanan'])
        <form action="{{ route('pesanan.update', $pesanan->id_pesanan) }}" method="POST">
            @csrf
            @method('PUT')

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
                        'required' => true,
                        'value' => old('id_pelanggan', $pesanan->id_pelanggan)
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Status',
                        'name' => 'status',
                        'type' => 'select',
                        'options' => ['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'],
                        'required' => true,
                        'value' => old('status', $pesanan->status)
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Tanggal Pesanan',
                        'name' => 'tanggal_pesanan',
                        'type' => 'date',
                        'required' => true,
                        'value' => old('tanggal_pesanan', $pesanan->tanggal_pesanan->format('Y-m-d'))
                    ])
                </div>

                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Catatan',
                        'name' => 'catatan',
                        'textarea' => true,
                        'rows' => 3,
                        'value' => old('catatan', $pesanan->catatan)
                    ])
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
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
