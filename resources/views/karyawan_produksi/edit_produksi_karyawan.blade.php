@extends('layouts.app')

@section('title', 'Edit Produksi Karyawan')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Edit Produksi Karyawan',
        'subtitle' => 'Edit data produksi karyawan',
        'breadcrumbs' => [
            ['label' => 'Karyawan Produksi', 'url' => route('karyawan_produksi.index')],
            ['label' => 'Edit']
        ]
    ])
    @endcomponent

    @component('components.card', ['title' => 'Form Edit Produksi Karyawan'])
        <form action="{{ route('karyawan_produksi.update', $produksiKaryawan->id_karyawan_produksi ?? $produksiKaryawan->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('components.errors')

            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Karyawan',
                        'name' => 'id_karyawan',
                        'type' => 'select',
                        'options' => $karyawans->pluck('nama', 'id_karyawan')->toArray(),
                        'required' => true,
                        'value' => old('id_karyawan', $produksiKaryawan->id_karyawan ?? '')
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Produksi',
                        'name' => 'id_produksi',
                        'type' => 'select',
                        'options' => $produksis->pluck('produk.nama_produk', 'id_produksi')->toArray(),
                        'required' => true,
                        'value' => old('id_produksi', $produksiKaryawan->id_produksi ?? '')
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Tanggal Produksi',
                        'name' => 'tanggal_produksi',
                        'type' => 'date',
                        'required' => true,
                        'value' => old('tanggal_produksi', $produksiKaryawan->tanggal_produksi?->format('Y-m-d') ?? '')
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Jumlah Unit',
                        'name' => 'jumlah_unit',
                        'type' => 'number',
                        'required' => true,
                        'placeholder' => 'Jumlah unit yang diproduksi',
                        'value' => old('jumlah_unit', $produksiKaryawan->jumlah_unit ?? '')
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-secondary">
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
