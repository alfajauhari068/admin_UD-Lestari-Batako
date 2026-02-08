@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
<div class="page-container p-fluid">
    <div class="mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pesanan.index') }}">Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>

    <h4 class="mt-4 fw-bold text-primary">Edit Pesanan</h4>

    <form action="{{ route('pesanan.update', $KurirData->id_pesanan ?? $KurirData->id) }}" method="POST" class="card custom-card p-4 p-md-5 rounded-4 mx-auto">
        @csrf
        @method('PUT')

        <h4 class="fw-bold text-primary mb-5 text-center">Form Edit Pesanan</h4>

        {{-- Pelanggan --}}
        <div class="mb-4">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select id="id_pelanggan" name="id_pelanggan" class="form-select @error('id_pelanggan') is-invalid @enderror" required>
                <option value="">Pilih Pelanggan</option>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id_pelanggan }}" {{ ($KurirData->id_pelanggan ?? old('id_pelanggan')) == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                        {{ $pelanggan->nama }}
                    </option>
                @endforeach
            </select>
            @error('id_pelanggan')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Pesan --}}
        <div class="mb-4">
            <label for="tgl_pesan" class="form-label">Tanggal Pesan</label>
            <input type="date" id="tgl_pesan" name="tgl_pesan" class="form-control @error('tgl_pesan') is-invalid @enderror" value="{{ old('tgl_pesan', $KurirData->tgl_pesan ?? '') }}" required>
            @error('tgl_pesan')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="pending" {{ ($KurirData->status ?? old('status')) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ ($KurirData->status ?? old('status')) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ ($KurirData->status ?? old('status')) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ ($KurirData->status ?? old('status')) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
            <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save2 me-2"></i>Update
            </button>
        </div>
    </form>
</div>
@endsection
