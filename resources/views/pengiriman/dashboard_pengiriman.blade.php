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
    <div class="">
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
            <button class="btn btn-primary shadow-sm d-flex align-items-center gap-1" disabled title="Tambah pengiriman dari halaman pesanan">
                <i class="bi bi-plus-circle-fill"></i> Tambah Pengiriman
            </button>
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
                            <th><center>Kode Pengiriman</center></th>
                            <th><center>Pesanan</center></th>
                            <th><center>Tanggal Kirim</center></th>
                            <th><center>Status</center></th>
                            <th><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengirimans as $pengiriman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pengiriman->kode_pengiriman }}</td>
                            <td>{{ $pengiriman->pesanan->kode_pesanan ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengiriman->tgl_kirim)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $pengiriman->status === 'diterima' ? 'success' : ($pengiriman->status === 'gagal' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($pengiriman->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('pengiriman.show', $pengiriman->id_pengiriman) }}"
                                       class="btn btn-sm btn-info btn-icon"
                                       data-bs-toggle="tooltip" title="Detail Pengiriman">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('pengiriman.edit', $pengiriman->id_pengiriman) }}"
                                       class="btn btn-sm btn-warning btn-icon"
                                       data-bs-toggle="tooltip" title="Edit Pengiriman">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('pengiriman.destroy', $pengiriman->id_pengiriman) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus pengiriman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger btn-icon"
                                                data-bs-toggle="tooltip" title="Hapus Pengiriman">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">Belum ada pengiriman.</td>
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
