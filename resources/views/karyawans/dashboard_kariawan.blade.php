@extends('layouts.app')

@section('content')
<div class="d-flex">
    <div class="container-fluid py-5 p-5" style="padding-top: 80px; background:rgba(252,252,252,0.61); min-height: 100vh;">
        
    {{-- Header --}}
        <section class="dashboard-header">
            <h1>Daftar Karyawan</h1>
            <p>Manajemen karyawan UD. Lestari Batako</p>
        </section>

        {{-- Breadcrumb --}}
        <div class="mt-1">
            @component('components.breadcrumb')
                @slot('breadcrumbs', [['name' => 'Karyawan', 'url' => route('karyawans.index')]])
            @endcomponent
        </div>

        {{-- Header dan Tombol Tambah --}}
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-auto">
                <h4 class="fw-bold text-primary"><i class="bi bi-people"></i>Daftar Karyawan</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('karyawans.create_kariawan') }}" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px;">
                    <i class="bi bi-plus-circle fs-4 d-flex justify-content-center align-items-center"></i>
                </a>
            </div>
        </div>

        {{-- Card dan Tabel --}}
        <div class="table-industrial-wrapper">
            <div style="padding: 1.5rem;">
                
                {{-- Alert --}}
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="bi bi-exclamation-circle-fill text-danger me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-industrial striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Posisi</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawans as $karyawan)
                            <tr>
                                <td style="text-align: center; width: 60px;">{{ $loop->iteration }}</td>
                                <td>{{ $karyawan->nama }}</td>
                                <td>{{ $karyawan->jabatan }}</td>
                                <td>{{ $karyawan->no_hp }}</td>
                                <td>{{ $karyawan->alamat }}</td>
                                <td style="text-align: center;">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Edit --}}
                                        <a href="{{ route('karyawans.edit', $karyawan->id_karyawan) }}"
                                           class="btn btn-sm btn-info btn-icon" data-bs-toggle="tooltip" title="Edit Karyawan">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('karyawans.destroy', $karyawan->id_karyawan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon" data-bs-toggle="tooltip" title="Hapus Karyawan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94A3B8; padding: 2rem;">Belum ada data karyawan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
