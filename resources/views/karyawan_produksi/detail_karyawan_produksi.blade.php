@extends('layouts.app')

@section('title', 'Detail Produksi Karyawan')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('karyawan_produksi.index') }}">Karyawan Produksi</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Detail Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Produksi Karyawan</h5>
                        <a href="{{ route('karyawan_produksi.edit', $produksiKaryawan->id_karyawan_produksi) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted ps-0">Karyawan</td>
                            <td class="fw-bold">{{ $produksiKaryawan->karyawan->nama ?? 'Tanpa Karyawan' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Produksi (Produk)</td>
                            <td>{{ $produksiKaryawan->produksi->produk->nama_produk ?? 'Tanpa Produk' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Upah per Unit</td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    Rp {{ number_format($produksiKaryawan->produksi->upah_per_unit ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Tanggal Produksi</td>
                            <td>{{ \Carbon\Carbon::parse($produksiKaryawan->tanggal_produksi)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Jumlah Unit</td>
                            <td>
                                <span class="badge bg-info fs-6">
                                    {{ number_format($produksiKaryawan->jumlah_unit) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Total Upah</td>
                            <td>
                                <span class="badge bg-primary fs-6">
                                    Rp {{ number_format(($produksiKaryawan->produksi->upah_per_unit ?? 0) * $produksiKaryawan->jumlah_unit, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Dibuat</td>
                            <td>{{ $produksiKaryawan->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <!-- Delete Button -->
                    <hr>
                    <form action="{{ route('karyawan_produksi.destroy', $produksiKaryawan->id_karyawan_produksi) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin hapus data produksi karyawan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-trash"></i> Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Additional Info Card -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Informasi Tambahan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted d-block">Satuan Produksi</small>
                                <strong>{{ $produksiKaryawan->produksi->satuan ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted d-block">Keterangan Produksi</small>
                                <strong>{{ $produksiKaryawan->produksi->keterangan ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
