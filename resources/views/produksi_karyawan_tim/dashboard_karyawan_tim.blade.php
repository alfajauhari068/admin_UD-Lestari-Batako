@extends('layouts.app')

@section('content')
<div class="d-flex">
    <div class="container-fluid p-5 py-5" style="min-height: 100vh; background: #f9f9f9;">

        {{-- Page Header --}}
        @component('components.page-header', [
            'title' => 'Produksi Karyawan Tim',
            'subtitle' => 'Manajemen produksi karyawan tim UD. Lestari Batako',
            'breadcrumbs' => [
                ['label' => 'Tim Produksi', 'url' => route('produksi_karyawan_tim.index')]
            ],
            'actions' => '
                <a href="'.route('produksi.index').'" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="bi bi-eye me-1"></i>Lihat Produksi
                </a>
                <a href="'.route('produksi_karyawan_tim.create').'" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Tambah
                </a>
            '
        ])
        @endcomponent

        {{-- Card --}}
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body">

                {{-- alerts --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- table --}}
                <div class="table-responsive">
                    <table class="table table-industrial striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Produksi</th>
                                <th>Tanggal Produksi</th>
                                <th class="text-center">Total Unit</th>
                                <th class="text-center">Jumlah Anggota</th>
                                <th class="text-end">Total Gaji Tim</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produksiKaryawanTims as $produksiKaryawanTim)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $produksiKaryawanTim->produksi->produk->nama_produk ?? 'N/A' }}</td>
                                    <td>{{ $produksiKaryawanTim->tanggal_produksi }}</td>
                                    <td class="text-center">{{ $produksiKaryawanTim->total_unit ?? 0 }}</td>
                                    <td class="text-center">{{ $produksiKaryawanTim->jumlah_anggota ?? 0 }}</td>
                                    <td class="text-end">Rp{{ number_format($produksiKaryawanTim->total_gaji_tim ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('produksi_karyawan_tim.detail', ['id' => $produksiKaryawanTim->id_produksi, 'tanggal' => $produksiKaryawanTim->tanggal_produksi]) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('produksi_karyawan_tim.edit_group', ['id' => $produksiKaryawanTim->id_produksi, 'tanggal' => $produksiKaryawanTim->tanggal_produksi]) }}" class="btn btn-sm btn-warning" title="Edit Tim">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('produksi_karyawan_tim.destroy_group', ['id' => $produksiKaryawanTim->id_produksi, 'tanggal' => $produksiKaryawanTim->tanggal_produksi]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua anggota tim untuk produksi ini pada tanggal tersebut?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Tim">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data produksi karyawan tim.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-footer bg-white border-0">
                <div class="text-muted small">Menampilkan kejadian produksi yang digroup berdasarkan produksi + tanggal.</div>
            </div>
        </div>

    </div>
</div>
@endsection
