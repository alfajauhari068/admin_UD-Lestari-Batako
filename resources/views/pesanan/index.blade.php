@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Daftar Pesanan',
        'subtitle' => 'Manajemen pesanan UD. Lestari Batako',
        'breadcrumbs' => [
            ['label' => 'Pesanan', 'url' => route('pesanan.index')]
        ],
        'actions' => '
            <a href="'.route('pesanan.create').'" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Baru
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
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $pesanan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $pesanan->pelanggan->nama ?? '-' }}</td>
                            <td>{{ $pesanan->tanggal_pesanan?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $pesanan->status === 'selesai' ? 'bg-success' : ($pesanan->status === 'dibatalkan' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($pesanan->total_harga,0,',','.') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pesanan.show', $pesanan->id_pesanan) }}"
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($pesanan->status !== 'selesai' && $pesanan->status !== 'dibatalkan')
                                    <a href="{{ route('pesanan.edit', $pesanan->id_pesanan) }}"
                                       class="btn btn-outline-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                @component('components.empty-state', [
                                    'icon' => 'cart',
                                    'title' => 'Belum ada pesanan',
                                    'actionLabel' => 'Buat Pesanan',
                                    'actionRoute' => route('pesanan.create')
                                ])
                                @endcomponent
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($data) && method_exists($data, 'links'))
            <div class="mt-3 d-flex justify-content-end">
                {{ $data->withQueryString()->links() }}
            </div>
        @endif
    @endcomponent

</div>
@endsection
