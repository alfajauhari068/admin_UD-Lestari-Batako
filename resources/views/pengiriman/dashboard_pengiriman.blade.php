@extends('layouts.app')

@section('title', 'Daftar Pengiriman')

@section('content')
<div class="page-container p-fluid">

    {{-- Header --}}
    <section class="dashboard-header">
        <h1>Daftar Pengiriman</h1>
        <p>Manajemen pengiriman UD. Lestari Batako</p>
    </section>

    {{-- Breadcrumb --}}
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengiriman</li>
            </ol>
        </nav>
    </div>

    {{-- Header Actions --}}
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-truck-fill me-2"></i>Daftar Pengiriman
            </h4>
        </div>
        <div class="col-auto">
            <a href="{{ route('pengiriman.create') }}" 
               class="btn btn-primary shadow-sm d-flex align-items-center gap-1" 
               data-bs-toggle="tooltip" 
               title="Tambah pengiriman baru">
                <i class="bi bi-plus-circle-fill"></i> Tambah Pengiriman
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="table-industrial-wrapper">
        <div class="page-container">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Kode Pesanan</th>
                            <th class="text-center">Pelanggan</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Tanggal Kirim</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengirimans as $pengiriman)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                <span class="badge bg-info">
                                    #PSN-{{ str_pad($pengiriman->pesanan->id_pesanan ?? 0, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $pengiriman->pesanan->pelanggan->nama ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">
                                        <i class="bi bi-telephone"></i> {{ $pengiriman->pesanan->pelanggan->no_hp ?? '-' }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <small>{{ Str::limit($pengiriman->alamat_pengiriman ?? '-', 50) }}</small>
                                @if($pengiriman->latitude && $pengiriman->longitude)
                                <br><small class="text-muted">
                                    <i class="bi bi-geo-alt-fill"></i> GPS: {{ number_format($pengiriman->latitude, 4) }}, {{ number_format($pengiriman->longitude, 4) }}
                                </small>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $pengiriman->tanggal_pengiriman ? \Carbon\Carbon::parse($pengiriman->tanggal_pengiriman)->format('d M Y') : '-' }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $pengiriman->jenis_pengiriman ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusBadge = [
                                        'Menunggu Dijadwalkan' => 'warning',
                                        'Dalam Pengiriman' => 'info',
                                        'Terkirim' => 'success',
                                        'Dibatalkan' => 'danger',
                                    ];
                                    $badgeClass = $statusBadge[$pengiriman->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">
                                    {{ $pengiriman->status ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('pengiriman.show', $pengiriman->id_pengiriman) }}"
                                       class="btn btn-sm btn-info btn-icon"
                                       data-bs-toggle="tooltip" 
                                       title="Detail Pengiriman">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('pengiriman.edit', $pengiriman->id_pengiriman) }}"
                                       class="btn btn-sm btn-warning btn-icon"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Pengiriman">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('pengiriman.destroy', $pengiriman->id_pengiriman) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus pengiriman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger btn-icon"
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Pengiriman">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox display-1 text-muted"></i>
                                    <h5 class="mt-3 text-muted">Belum Ada Pengiriman</h5>
                                    <p class="text-muted">Silakan tambah pengiriman baru untuk memulai</p>
                                    <a href="{{ route('pengiriman.create') }}" class="btn btn-primary mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>Tambah Pengiriman
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize tooltips
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });
</script>

<style>
.empty-state {
    padding: 3rem 1rem;
}

.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.custom-table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transition: background-color 0.2s ease;
}
</style>

@endsection
