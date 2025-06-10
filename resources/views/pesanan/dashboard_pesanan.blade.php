<-- link style css -->
  <link href="{{ asset('assets/style.css') }}" rel="stylesheet">
@extends('layouts.navbar')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar') {{-- Sidebar --}}
    <div class="container-fluid py-4 p-5" style="margin-left: 250px; padding-top: 80px; background: linear-gradient(to right, #f8f9fa, #e9ecef); min-height: 100vh;">
           
        <div class="mt-5">
         @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Pesanan', 'url' => route('pesanan.index')]
                ])
            @endcomponent</div>
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-auto">
                <h4 class="fw-bold text-primary">Dashboard Pesanan</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('pesanan.create') }}" class="btn btn-primary rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
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
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th><center>No</center></th>
                                <th><center>ID Pesanan</center></th>
                                <th><center>Pelanggan</center></th>
                                <th><center>Catatan</center></th>
                                <th><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanans as $pesanan)
                            <tr>
                                <td><center>{{ $loop->iteration }}</center></td>
                                <td><center>{{ $pesanan->id_pesanan }}</center></td>
                                <td><center>{{ $pesanan->pelanggan->nama }}</center></td>
                                <td><center>{{ $pesanan->catatan ?? '-' }}</center></td>
                                <td><center>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('pesanan.detail', $pesanan->id_pesanan) }}" 
                                           class="btn btn-primary btn-sm d-flex align-items-center gap-1 rounded-circle" 
                                           data-mdb-ripple-init role="button" 
                                           data-bs-toggle="tooltip" title="Lihat Detail Pesanan" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Tombol Atur Pengiriman -->
                                        <a href="{{ route('pengiriman.create', $pesanan->id_pesanan) }}" 
                                           class="btn btn-success btn-sm d-flex align-items-center gap-1 rounded-circle
                                           data-bs-toggle="tooltip" title="Atur Pengiriman">
                                            <i class="bi bi-truck"></i>
                                        </a>

                                        
                                    </div>
                                </td>
                            </center></tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada pesanan.</td>
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