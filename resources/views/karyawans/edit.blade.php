@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Edit Karyawan',
        'subtitle' => 'Edit informasi karyawan',
        'breadcrumbs' => [
            ['label' => 'Karyawan', 'url' => route('karyawans.index')],
            ['label' => 'Edit']
        ]
    ])
    @endcomponent

    @component('components.card', ['title' => 'Edit Karyawan: ' . ($karyawan->nama ?? '')])
        <form action="{{ route('karyawans.update', $karyawan->id_karyawan) }}" method="POST">
            @csrf
            @method('PUT')
            @include('components.errors')

            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Nama Karyawan',
                        'name' => 'nama',
                        'type' => 'text',
                        'required' => true,
                        'value' => old('nama', $karyawan->nama ?? '')
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Jabatan',
                        'name' => 'jabatan',
                        'type' => 'text',
                        'required' => true,
                        'value' => old('jabatan', $karyawan->jabatan ?? '')
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'No HP',
                        'name' => 'no_hp',
                        'type' => 'text',
                        'value' => old('no_hp', $karyawan->no_hp ?? '')
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Status',
                        'name' => 'status',
                        'type' => 'select',
                        'options' => ['aktif' => 'Aktif', 'non-aktif' => 'Non-Aktif'],
                        'required' => true,
                        'value' => old('status', $karyawan->status ?? 'aktif')
                    ])
                </div>
                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Alamat',
                        'name' => 'alamat',
                        'textarea' => true,
                        'rows' => 3,
                        'value' => old('alamat', $karyawan->alamat ?? '')
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('karyawans.index') }}" class="btn btn-secondary">
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
