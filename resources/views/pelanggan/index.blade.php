@extends('layouts.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Daftar Pelanggan',
        'subtitle' => 'Manajemen pelanggan UD. Lestari Batako',
        'breadcrumbs' => [
            ['label' => 'Pelanggan', 'url' => route('pelanggan.index')]
        ],
        'actions' => '
            <a href="'.route('pelanggan.create').'" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah
            </a>
        '
    ])
    @endcomponent

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Data Card --}}
    @component('components.card')
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($KurirData as $pelanggan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $pelanggan->nama }}</td>
                            <td>{{ $pelanggan->email ?? '-' }}</td>
                            <td>{{ $pelanggan->no_hp ?? '-' }}</td>
                            <td>{{ Str::limit($pelanggan->alamat ?? '-', 30) }}</td>
                            <td class="text-muted small">{{ $pelanggan->created_at->format('d M Y H:i') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}"
                                       class="btn btn-outline-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('pesanan.create', ['id_pelanggan' => $pelanggan->id_pelanggan]) }}"
                                       class="btn btn-outline-success"
                                       data-bs-toggle="tooltip" title="Atur Pesanan">
                                        <i class="bi bi-cart-check"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmModal"
                                            data-action="{{ route('pelanggan.destroy', $pelanggan->id_pelanggan) }}"
                                            data-title="Hapus Pelanggan"
                                            data-message="Apakah Anda yakin ingin menghapus pelanggan '{{ $pelanggan->nama }}'?"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                @component('components.empty-state', [
                                    'icon' => 'people',
                                    'title' => 'Belum ada pelanggan',
                                    'actionLabel' => 'Tambah Pelanggan',
                                    'actionRoute' => route('pelanggan.create')
                                ])
                                @endcomponent
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($KurirData, 'links'))
            <div class="mt-3 d-flex justify-content-end">
                {{ $KurirData->withQueryString()->links() }}
            </div>
        @endif
    @endcomponent

</div>
@endsection
