@extends('layouts.app')

@section('title', 'Buat Pesanan')

@section('content')
<?php
$pelanggans = $pelanggans ?? [];
?>
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Buat Pesanan',
        'subtitle' => 'Buat pesanan baru untuk pelanggan',
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

            {{-- Pesanan Header Information --}}
            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Pelanggan',
                        'name' => 'id_pelanggan',
                        'type' => 'select',
                        'options' => $pelanggans,
                        'required' => true,
                        'help' => 'Pilih pelanggan untuk pesanan ini'
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Tanggal Pesanan',
                        'name' => 'tanggal_pesanan',
                        'type' => 'date',
                        'required' => true,
                        'value' => now()->format('Y-m-d'),
                        'help' => 'Tanggal pesanan dibuat'
                    ])
                </div>

                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Catatan (Opsional)',
                        'name' => 'catatan',
                        'textarea' => true,
                        'rows' => 3,
                        'placeholder' => 'Tambahkan catatan atau instruksi khusus untuk pesanan ini...',
                        'help' => 'Catatan akan ditampilkan pada detail pesanan'
                    ])
                </div>
            </div>

            {{-- Info Box --}}
            <div class="alert alert-info mt-4" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Info:</strong> Setelah pesanan dibuat, Anda dapat menambahkan produk melalui halaman detail pesanan.
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save2 me-1"></i>Buat Pesanan
                </button>
            </div>
        </form>
    @endcomponent

</div>
@endsection
