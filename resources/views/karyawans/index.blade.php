@extends('layouts.app')

@section('title', 'Daftar Karyawan')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Daftar Karyawan',
        'subtitle' => 'Manajemen karyawan UD. Lestari Batako',
        'breadcrumbs' => [
            ['label' => 'Karyawan', 'url' => route('karyawans.index')]
        ],
        'actions' => '
            <a href="'.route('karyawans.create').'" class="btn btn-primary btn-sm" title="Tambah Karyawan Baru">
                <i class="bi bi-plus-circle me-1"></i>Tambah Karyawan
            </a>
        '
    ])
    @endcomponent

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @component('components.card')
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $karyawan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $karyawan->nama }}</td>
                            <td>{{ $karyawan->jabatan }}</td>
                            <td>{{ $karyawan->no_hp ?? '-' }}</td>
                            <td>{{ $karyawan->alamat ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('karyawans.show', $karyawan->id_karyawan) }}"
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('karyawans.edit', $karyawan->id_karyawan) }}"
                                       class="btn btn-outline-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('karyawans.destroy', $karyawan->id_karyawan) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin hapus karyawan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-person-badge fs-1 d-block mb-2"></i>
                                    <p class="mb-0">Belum ada karyawan</p>
                                    <a href="{{ route('karyawans.create') }}" class="btn btn-primary btn-sm mt-2">
                                        Tambah Karyawan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endcomponent

</div>
@endsection
