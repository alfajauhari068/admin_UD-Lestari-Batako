<!-- filepath: d:\KULIAH\Semester4\Interaksi Manusia dan Komputer\tugas-3\ud_lestari-batako\resources\views\pelanggan\dashboard_pelanggan.blade.php -->
@extends('layouts.navbar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">Daftar Pelanggan</h2>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Pelanggan</h4>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pelanggan
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggans as $pelanggan)
                        <tr onclick="window.location='{{ route('pelanggan.riwayat', $pelanggan->id_pelanggan) }}'" style="cursor: pointer;">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pelanggan->nama }}</td>
                            <td>{{ $pelanggan->email ?? '-' }}</td>
                            <td>{{ $pelanggan->no_hp ?? '-' }}</td>
                            <td>{{ $pelanggan->alamat ?? '-' }}</td>
                            <td>{{ $pelanggan->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}" 
                                       class="btn btn-warning btn-sm rounded-pill d-flex align-items-center gap-1" 
                                       data-bs-toggle="tooltip" title="Edit Pelanggan">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('pelanggan.destroy', $pelanggan->id_pelanggan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm rounded-pill d-flex align-items-center gap-1" 
                                                onclick="return confirm('Yakin hapus pelanggan ini?')" 
                                                data-bs-toggle="tooltip" title="Hapus Pelanggan">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada pelanggan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-end small text-muted">
            UD Lestari Batako &copy; {{ date('Y') }}
        </div>
    </div>
</div>
@endsection