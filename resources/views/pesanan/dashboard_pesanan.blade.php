@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="page-container p-fluid">

    {{-- Header --}}
    <section class="dashboard-header">
        <h1>Daftar Pesanan</h1>
        <p>Manajemen pesanan UD. Lestari Batako</p>
    </section>

    {{-- Breadcrumb --}}
    <div class="">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pesanan</li>
            </ol>
        </nav>
    </div>

    {{-- Header Actions --}}
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-cart-fill me-2"></i>Daftar Pesanan
            </h4>
        </div>
        <div class="col-auto">
            <a href="{{ route('pesanan.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center gap-1">
                <i class="bi bi-plus-circle-fill"></i> Tambah Pesanan
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

    {{-- Table Card --}}
    <div class="table-industrial-wrapper">
        <div class="page-container">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th><center>No</center></th>
                            <th><center>Kode Pesanan</center></th>
                            <th><center>Pelanggan</center></th>
                            <th><center>Tanggal Pesan</center></th>
                            <th><center>Status</center></th>
                            <th><center>Total Harga</center></th>
                            <th><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanans as $pesanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pesanan->kode_pesanan }}</td>
                            <td>{{ $pesanan->pelanggan->nama ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $pesanan->status === 'selesai' ? 'success' : ($pesanan->status === 'dibatalkan' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($pesanan->calculateTotal(), 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('pesanan.show', $pesanan->id_pesanan) }}"
                                       class="btn btn-sm btn-info btn-icon"
                                       data-bs-toggle="tooltip" title="Detail Pesanan">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('pesanan.edit', $pesanan->id_pesanan) }}"
                                       class="btn btn-sm btn-warning btn-icon"
                                       data-bs-toggle="tooltip" title="Edit Pesanan">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('pesanan.destroy', $pesanan->id_pesanan) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger btn-icon"
                                                data-bs-toggle="tooltip" title="Hapus Pesanan">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Belum ada pesanan.</td>
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
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });
</script>
@endsection
