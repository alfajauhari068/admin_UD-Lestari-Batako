@extends('layouts.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="page-container p-fluid">

    {{-- Header --}}
    <section class="dashboard-header">
        <h1>Daftar Pelanggan</h1>
        <p>Manajemen pelanggan UD. Lestari Batako</p>
    </section>

    {{-- Breadcrumb --}}
    <div class="">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
            </ol>
        </nav>
    </div>

    {{-- Header --}}
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-people-fill me-2"></i>Daftar Pelanggan
            </h4>
        </div>
        <div class="col-auto">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center gap-1">
                <i class="bi bi-plus-circle-fill"></i> Tambah Pelanggan
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
                            <th><center>Nama</center></th>
                            <th><center>Email</center></th>
                            <th><center>No HP</center></th>
                            <th><center>Alamat</center></th>
                            <th><center>Dibuat</center></th>
                            <th><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($KurirData as $pelanggan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pelanggan->nama }}</td>
                            <td>{{ $pelanggan->email ?? '-' }}</td>
                            <td>{{ $pelanggan->no_hp ?? '-' }}</td>
                            <td>{{ $pelanggan->alamat ?? '-' }}</td>
                            <td>{{ $pelanggan->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}"
                                       class="btn btn-sm btn-warning btn-icon"
                                       data-bs-toggle="tooltip" title="Edit Pelanggan">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    {{-- Atur Pesanan --}}
                                    <a href="{{ route('pesanan.create', ['id_pelanggan' => $pelanggan->id_pelanggan]) }}"
                                       class="btn btn-sm btn-success btn-icon"
                                       data-bs-toggle="tooltip" title="Atur Pesanan">
                                        <i class="bi bi-cart-check-fill"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('pelanggan.destroy', $pelanggan->id_pelanggan) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger btn-icon"
                                                data-bs-toggle="tooltip" title="Hapus Pelanggan">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Belum ada pelanggan.</td>
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
