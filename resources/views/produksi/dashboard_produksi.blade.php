@extends('layouts.navbar')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    @extends('layouts.sidebar')

    <!-- Main Content -->
    <div class="container-fluid py-5 p-5 mt-5" style="margin-left: 250px; padding-top: 80px; background:rgba(252, 252, 252, 0.61); min-height: 100vh;">
    <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produksi', 'url' => route('produksi.index')]
                ])
            @endcomponent
            </div>
        <div class="row justify-content-between align-items-center mb-3">
        <div class="col-auto">
            <h4 class="fw-bold text-primary">Daftar Produksi</h4>
        </div>
        <div class="col-auto">
            <a href="{{ route('produksi.create') }}" class="btn btn-primary rounded-circle mb-3" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
                <i class="bi bi-plus-circle fs-4"></i>
            </a>
        </div>
        </div>
        
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert">
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

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Nama Produksi</center></th>
                                <th><center>Kriteria Gaji</center></th>
                                <th><center>Gaji Per Unit</center></th>
                                <th><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produksis as $produksi)
                            <tr>
                                <td><center>{{ $loop->iteration }}</center></td>
                                <td><center>{{ $produksi->nama_produksi }}</center></td>
                                <td><center>{{ $produksi->kriteria_gaji }}</center></td>
                                <td><center>Rp{{ number_format($produksi->gaji_per_unit, 0, ',', '.') }}</center></td>
                                <td><center>
                                    <div class="d-flex gap-2 justify-content-center">
                                        

                                        <!-- Tombol Edit -->
                                        <button class="btn btn-primary btn-sm d-flex align-items-center gap-1 rounded-circle" 
                                                data-mdb-ripple-init type="button" 
                                                onclick="window.location.href='{{ route('produksi.edit', $produksi->id_produksi) }}'" 
                                                data-bs-toggle="tooltip" title="Edit Produksi" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button class="btn btn-danger btn-sm d-flex align-items-center gap-1 rounded-circle" 
                                                    data-mdb-ripple-init type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus produksi ini?')" 
                                                    data-bs-toggle="tooltip" title="Hapus Produksi" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                                                <i class="bi bi-trash"></i>
                                        <form action="{{ route('produksi.destroy', $produksi->id_produksi) }}" method="POST" style="display:inline;rounded-circle">
                                            @csrf
                                            @method('DELETE')
                                            
                                            </button>
                                        </form>
                                    </div>
                                </center></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data produksi.</td>
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