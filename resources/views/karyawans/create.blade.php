@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Tambah Karyawan',
        'subtitle' => 'Tambah karyawan baru',
        'breadcrumbs' => [
            ['label' => 'Karyawan', 'url' => route('karyawans.index')],
            ['label' => 'Tambah']
        ]
    ])
    @endcomponent

    @component('components.card', ['title' => 'Informasi Karyawan'])
        <form action="{{ route('karyawans.store') }}" method="POST">
            @csrf
            @include('components.errors')

            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Nama Karyawan',
                        'name' => 'nama',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Masukkan nama'
                    ]) 
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Jabatan',
                        'name' => 'jabatan',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Masukkan jabatan'
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'No HP',
                        'name' => 'no_hp',
                        'type' => 'text',
                        'placeholder' => 'Masukkan nomor HP'
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Status',
                        'name' => 'status',
                        'type' => 'select',
                        'options' => ['aktif' => 'Aktif', 'non-aktif' => 'Non-Aktif'],
                        'required' => true,
                        'value' => 'aktif'
                    ])
                </div>
                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Alamat',
                        'name' => 'alamat',
                        'textarea' => true,
                        'rows' => 3
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('karyawans.index') }}" class="btn btn-secondary">
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
