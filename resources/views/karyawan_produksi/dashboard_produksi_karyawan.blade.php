@extends('layouts.navbar')
@extends('layouts.sidebar')

@section('content')
<div class="d-flex">
    <!-- Main Content -->
    <div class="container-fluid py-5 mt-5" style="margin-left: 250px; padding-top: 80px; background:rgba(252, 252, 252, 0.61); min-height: 100vh;">
    <!-- Breadcrumb -->
    <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produksi Karyawan', 'url' => route('karyawan_produksi.index')]
                ])
            @endcomponent
    </div>
        <div class="row justify-content-between align-items-center mb-5 p-3">
        <div class="col-auto">
        <h4 class="fw-bold text-primary">Daftar Produksi Karyawan</h4>
        </div>
        <div class="col-auto">
            <a href="{{ route('karyawan_produksi.create') }}" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
                <i class="bi bi-plus-circle fs-4"></i>
            </a>
        </div>
        </div>
        

        <!-- Tombol Tambah Produksi -->
        

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
                                <th><center>Tanggal Produksi</center></th>
                                <th><center>Jumlah Unit</center></th>
                                <th><center>Upah Total</center></th>
                                <th><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produksiKaryawans as $ProduksiKaryawan)
                            <tr>
                                <td><center>{{ $loop->iteration }}</center></td>
                                <td><center>{{ $ProduksiKaryawan->produksi->nama_produksi }}</center></td>
                                <td><center>{{ $ProduksiKaryawan->tanggal_produksi }}</center></td>
                                <td><center>{{ $ProduksiKaryawan->jumlah_unit }}</center></td>
                                <td><center>Rp{{ number_format($ProduksiKaryawan->upah_total, 0, ',', '.') }}</center></td>
                                <td><center>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('karyawan_produksi.detail', $ProduksiKaryawan->id) }}" 
                                           class="btn btn-primary btn-sm d-flex align-items-center gap-1 rounded-circle" 
                                           data-mdb-ripple-init role="button" 
                                           data-bs-toggle="tooltip" title="Lihat Detail Produksi Karyawan" 
                                           style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        

                                        
                                    </div>
                                </center></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data produksi karyawan.</td>
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