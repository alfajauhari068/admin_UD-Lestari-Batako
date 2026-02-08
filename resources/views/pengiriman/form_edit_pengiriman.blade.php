@extends('layouts.app')

@section('title', 'Edit Pengiriman')

@section('content')
<div class="page-container p-fluid">
    <div class="mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengiriman.index') }}">Pengiriman</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>

    <h4 class="mt-4 fw-bold text-primary">Edit Pengiriman</h4>

    <form action="{{ route('pengiriman.update', $KurirData->id_pengiriman ?? $KurirData->id) }}" method="POST" class="card custom-card p-4 p-md-5 rounded-4 mx-auto">
        @csrf
        @method('PUT')

        <h4 class="fw-bold text-primary mb-5 text-center">Form Edit Pengiriman</h4>

        {{-- Pesanan --}}
        <div class="mb-4">
            <label for="id_pesanan" class="form-label">Pesanan</label>
            <select id="id_pesanan" name="id_pesanan" class="form-select @error('id_pesanan') is-invalid @enderror" required>
                <option value="">Pilih Pesanan</option>
                @foreach($pesanan as $p)
                    <option value="{{ $p->id_pesanan }}" {{ ($KurirData->id_pesanan ?? old('id_pesanan')) == $p->id_pesanan ? 'selected' : '' }}>
                        {{ $p->kode_pesanan }} - {{ $p->pelanggan->nama ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
            @error('id_pesanan')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Kirim --}}
        <div class="mb-4">
            <label for="tgl_kirim" class="form-label">Tanggal Kirim</label>
            <input type="date" id="tgl_kirim" name="tgl_kirim" class="form-control @error('tgl_kirim') is-invalid @enderror" value="{{ old('tgl_kirim', $KurirData->tgl_kirim ?? '') }}" required>
            @error('tgl_kirim')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="dikirim" {{ ($KurirData->status ?? old('status')) == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="diterima" {{ ($KurirData->status ?? old('status')) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="gagal" {{ ($KurirData->status ?? old('status')) == 'gagal' ? 'selected' : '' }}>Gagal</option>
            </select>
            @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
            <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save2 me-2"></i>Update
            </button>
        </div>
    </form>
</div>
@endsection
