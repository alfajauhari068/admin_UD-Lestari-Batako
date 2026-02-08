@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Edit Pelanggan',
        'subtitle' => 'Edit informasi pelanggan',
        'breadcrumbs' => [
            ['label' => 'Pelanggan', 'url' => route('pelanggan.index')],
            ['label' => 'Edit']
        ]
    ])
    @endcomponent

    {{-- Form Card --}}
    @component('components.card', ['title' => 'Edit Pelanggan: ' . ($pelanggan->nama ?? '')])
        <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Validation Errors --}}
            @include('components.errors')

            {{-- Form Fields --}}
            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Nama Pelanggan',
                        'name' => 'nama',
                        'type' => 'text',
                        'required' => true,
                        'value' => old('nama', $pelanggan->nama ?? ''),
                        'placeholder' => 'Masukkan nama pelanggan'
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Email',
                        'name' => 'email',
                        'type' => 'email',
                        'value' => old('email', $pelanggan->email ?? ''),
                        'placeholder' => 'Masukkan email'
                    ])
                </div>

                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Nomor HP',
                        'name' => 'no_hp',
                        'type' => 'text',
                        'value' => old('no_hp', $pelanggan->no_hp ?? ''),
                        'placeholder' => 'Masukkan nomor HP'
                    ])
                </div>

                <div class="col-12">
                    @include('components.form-group', [
                        'label' => 'Alamat',
                        'name' => 'alamat',
                        'textarea' => true,
                        'rows' => 3,
                        'value' => old('alamat', $pelanggan->alamat ?? ''),
                        'placeholder' => 'Masukkan alamat'
                    ])
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
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
