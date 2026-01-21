@extends('layouts.app')

@section('content')
<div class="page-container p-fluid">
    @component('components.breadcrumb')
        @slot('breadcrumbs', [
            ['name' => 'Pelanggan', 'url' => route('pelanggan.index')],
            ['name' => 'Tambah Pelanggan', 'url' => route('pelanggan.create')]
        ])
    @endcomponent
    <h2 class="mb-4 w-bold text-primary">Tambah Pelanggan</h2>
    <div class="card custom-card p-5">
        <div class="card-body p-0">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <h5 class="fw-bold text-primary mb-5">Informasi Pelanggan</h5>

            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf

                {{-- Nama --}}
                <div class="mb-4">
                    <label for="nama" class="form-label">Nama Pelanggan *</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" 
                           value="{{ old('nama') }}" required
                           placeholder="Masukkan nama pelanggan">
                    @error('nama')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                           value="{{ old('email') }}"
                           placeholder="Masukkan email pelanggan">
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No HP --}}
                <div class="mb-4">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" 
                           value="{{ old('no_hp') }}"
                           placeholder="Masukkan nomor HP pelanggan">
                    @error('no_hp')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-4">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control form-textarea @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                              placeholder="Masukkan alamat pelanggan">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary btn-secondary-custom">
                        <i class="bi bi-arrow-left-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-primary-custom">
                        <i class="bi bi-save2 me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

        </div>
    </div>
</div>
@endsection
</body>