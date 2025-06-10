{{-- filepath: d:\KULIAH\Semester4\Pemrograman FrameWork\ud_lestari-batako\resources\views\pengiriman\dashboard_pengiriman.blade.php --}}
@extends('layouts.navbar')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar') {{-- Sidebar --}}
    <div class="container-fluid py-4 p-5" style="margin-left: 250px; padding-top: 80px; background: linear-gradient(to right, #f8f9fa, #e9ecef); min-height: 100vh;">
        {{-- Judul Halaman --}}
        <div class="mt-5 pt-5">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Pengiriman', 'url' => route('pengiriman.index')]
                ])
            @endcomponent
            </div>
    <div class="row justify-content-between align-items-center ">
        <div class="col-auto">
            <h4 class="mb-4  fw-bold text-primary text-center">Dashboard Pengiriman</h4>
        </div>
    </div>
        {{-- Tabel Data Pengiriman --}}
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
                                <th><center>Nama Pelanggan</center></th>
                                <th><center>Alamat Pengiriman</center></th>
                                <th><center>Tanggal Pengiriman</center></th>
                                <th><center>Jasa Kirim</center></th>
                                <th><center>No Resi</center></th>
                                <th><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengirimans as $pengiriman)
                            <tr>
                                <td><center>{{ $loop->iteration }}</center></td>
                                <td><center>{{ $pengiriman->pesanan->pelanggan->nama }}</center></td>
                                <td><center>{{ $pengiriman->alamat_pengiriman }}</center></td>
                                <td><center>{{ $pengiriman->tanggal_pengiriman ? $pengiriman->tanggal_pengiriman->format('d M Y') : '-' }}</center></td>
                                <td><center>{{ $pengiriman->jasa_kurir ?? '-' }}</center></td>
                                <td><center>{{ $pengiriman->no_resi ?? '-' }}</center></td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('pengiriman.show', $pengiriman->id_pengiriman) }}" 
                                           class="btn btn-primary btn-sm d-flex align-items-center gap-1" 
                                           data-mdb-ripple-init role="button" 
                                           data-bs-toggle="tooltip" title="Lihat Detail Pengiriman">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm d-flex align-items-center gap-1" 
                                                data-mdb-ripple-init type="button" 
                                                onclick="window.location.href='{{ route('pengiriman.edit', $pengiriman->id_pengiriman) }}'" 
                                                data-bs-toggle="tooltip" title="Edit Pengiriman">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('pengiriman.destroy', $pengiriman->id_pengiriman) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm d-flex align-items-center gap-1 rounded-circle" 
                                                    data-mdb-ripple-init type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus pengiriman ini?')" 
                                                    data-bs-toggle="tooltip" title="Hapus Pengiriman">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data pengiriman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection