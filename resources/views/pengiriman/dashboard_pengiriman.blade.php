@extends('layouts.app')

@section('content')
<div class="page-container">

{{-- Header --}}
        <section class="dashboard-header">
            <h1>Daftar Pengiriman</h1>
            <p>Manajemen pengiriman UD. Lestari Batako</p>
        </section>

        {{-- Breadcrumb --}}
        <div class="pt-">
            @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Pengiriman', 'url' => route('pengiriman.index')]
                ])
            @endcomponent
        </div>

        {{-- Judul Halaman --}}
        <div class="row justify-content-between align-items-center mb-">
            <div class="col-auto">
                <h4 class="fw-bold text-primary"><i class="bi bi-truck"></i>Data Pengiriman</h4>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill text-success me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger mt-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle-fill text-danger me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Tabel Data Pengiriman --}}
        <div class="table-industrial-wrapper">
            <div class="p-3">
                <div class="table-responsive">
                    <table class="table custom-table striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat Pengiriman</th>
                                <th>Tanggal Pengiriman</th>
                                <th>Jasa Kirim</th>
                                <th>No Resi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengirimans as $pengiriman)
                            <tr class="text-center">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td>{{ $pengiriman->pesanan->pelanggan->nama }}</td>
                                <td>{{ $pengiriman->alamat_pengiriman }}</td>
                                <td>
                                    {{ $pengiriman->tanggal_pengiriman ? $pengiriman->tanggal_pengiriman->format('d M Y') : '-' }}
                                </td>
                                <td>{{ $pengiriman->jasa_kurir ?? '-' }}</td>
                                <td>{{ $pengiriman->no_resi ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('pengiriman.show', $pengiriman->id_pengiriman) }}"
                                           class="btn btn-primary btn-sm rounded-circle"
                                           data-bs-toggle="tooltip" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>


                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('pengiriman.edit', $pengiriman->id_pengiriman) }}"
                                           class="btn btn-warning btn-sm rounded-circle"
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('pengiriman.destroy', $pengiriman->id_pengiriman) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengiriman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-circle"
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted fst-italic">Belum ada data pengiriman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end small text-muted bg-white">
                UD Lestari Batako &copy; {{ date('Y') }}
            </div>
        </div>
    </div>
</div>

{{-- Tooltip Init --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });
</script>
@endsection
