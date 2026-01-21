@extends('layouts.app')

@section('content')
<div class="page-container">
            <div class="mt-">
            @component('components.breadcrumb')
                    @slot('breadcrumbs', [
                        ['name' => 'Pesanan', 'url' => route('pesanan.index')],
                        ['name' => 'Tambah Pesanan', 'url' => route('pesanan.create')]
                    ])
                @endcomponent
            </div>
    <h4 class="mb- mt-2 fw-bold text-primary">Tambah Pesanan</h4>
    <div class="card custom-card max-w-900">
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

            <form action="{{ route('pesanan.store') }}" method="POST">
    @csrf

    {{-- Pilih Pelanggan --}}
    <div class="mb-4">
        <label for="id_pelanggan" class="form-label fw-semibold">Pelanggan *</label>
        <select class="form-select form-control @error('id_pelanggan') is-invalid @enderror" id="id_pelanggan" name="id_pelanggan" required>
            <option value="" selected disabled>Pilih Pelanggan</option>
            @foreach($pelanggans as $pelanggan)
                <option value="{{ $pelanggan->id_pelanggan }}" {{ old('id_pelanggan') == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                    {{ $pelanggan->nama }}
                </option>
            @endforeach
        </select>
        @error('id_pelanggan')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Catatan --}}
    <div class="mb-4">
        <label for="catatan" class="form-label fw-semibold">Catatan</label>
        <textarea class="form-control form-textarea @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="4" placeholder="Tambahkan catatan jika perlu">{{ old('catatan') }}</textarea>
        @error('catatan')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Tombol --}}
    <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
        <a href="{{ route('pesanan.index') }}" class="btn btn-secondary-custom">
            <i class="bi bi-arrow-left-circle me-2"></i>Batal
        </a>
        <button type="submit" class="btn btn-primary-custom">
            <i class="bi bi-save me-2"></i>Simpan Pesanan
        </button>
    </div>
</form>

        </div>
    </div>
</div>
@endsection