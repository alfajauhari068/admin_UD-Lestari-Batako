@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="page-container p-fluid">
    <div class="mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>

    <h4 class="mt-4 fw-bold text-primary">Tambah Pelanggan Baru</h4>

    <form action="{{ route('pelanggan.store') }}" method="POST" class="card custom-card p-4 p-md-5 rounded-4 mx-auto">
        @csrf

        <h4 class="fw-bold text-primary mb-5 text-center">Form Tambah Pelanggan</h4>

        {{-- Nama --}}
        <div class="mb-4">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
            @error('nama')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email">
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- No HP --}}
        <div class="mb-4">
            <label for="no_hp" class="form-label">No. HP</label>
            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" placeholder="Masukkan nomor HP">
            @error('no_hp')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Alamat --}}
        <div class="mb-4">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save2 me-2"></i>Simpan
            </button>
        </div>
    </form>
</div>
@endsection
