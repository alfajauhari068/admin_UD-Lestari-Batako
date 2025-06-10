<!-- filepath: resources/views/pelanggan/dashboard_pelanggan.blade.php -->
@extends('layouts.navbar')

@section('content')
<div class="d-flex flex-wrap">
    @include('layouts.sidebar') <!-- Sidebar -->
    <div class="container-fluid py-4 p-5 mt-5" style="background: linear-gradient(to right, #f8f9fa, #e9ecef); min-height: 100vh; margin-left: 250px;">
        {{-- Judul Halaman --}}
        <div class="mt-5">
     @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Pelanggan', 'url' => route('pelanggan.index')],
                ])
            @endcomponent
            </div>
    
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-auto">
                <h4 class="fw-bold text-primary">Daftar Pelanggan</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
                    <i class="bi bi-plus-circle fs-4"></i>
                </a>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th><center>Nama</center></th>
                                <th><center>No</center></th>
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
                                <td><center>{{ $loop->iteration }}</center></td>
                                <td><center>{{ $pelanggan->nama }}</center></td>
                                <td><center>{{ $pelanggan->email ?? '-' }}</center></td>
                                <td><center>{{ $pelanggan->no_hp ?? '-' }}</center></td>
                                <td><center>{{ $pelanggan->alamat ?? '-' }}</center></td>
                                <td><center>{{ $pelanggan->created_at->format('d M Y H:i') }}</center></td>
                                <td><center>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}" 
                                           class="btn btn-primary btn-sm d-flex align-items-center gap-1" 
                                           data-mdb-ripple-init role="button" 
                                           data-bs-toggle="tooltip" title="Edit Pelanggan">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        

                                        <!-- Tombol Atur Pesanan -->
                                        <a href="{{ route('pesanan.create', ['id_pelanggan' => $pelanggan->id_pelanggan]) }}" 
                                           class="btn btn-primary btn-sm d-flex align-items-center gap-1" 
                                           data-mdb-ripple-init role="button" 
                                           data-bs-toggle="tooltip" title="Atur Pesanan">
                                            <i class="bi bi-cart-check-fill"></i>
                                        </a>

                                        <form action="{{ route('pelanggan.destroy', $pelanggan->id_pelanggan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm d-flex align-items-center gap-1 rounded-circle" 
                                                    data-mdb-ripple-init type="submit" 
                                                    onclick="return confirm('Yakin hapus pelanggan ini?')" 
                                                    data-bs-toggle="tooltip" title="Hapus Pelanggan" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                                                <i class="bi bi-trash"></i>
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
</div>
@endsection