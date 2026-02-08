@extends('layouts.app')

@section('title', 'Daftar Pengiriman')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Daftar Pengiriman',
        'subtitle' => 'Manajemen pengiriman pesanan',
        'breadcrumbs' => [
            ['label' => 'Pengiriman', 'url' => route('pengiriman.index')]
        ],
        'actions' => '
            <a href="'.route('pengiriman.create').'" class="btn btn-primary btn-sm">
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
                        <th>Pesanan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Driver</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $pengiriman)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $pengiriman->pesanan->id_pesanan ?? '-' }}</td>
                            <td>{{ $pengiriman->tanggal_pengiriman->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $pengiriman->status === 'terkirim' ? 'bg-success' : ($pengiriman->status === 'dibatalkan' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($pengiriman->status) }}
                                </span>
                            </td>
                            <td>{{ $pengiriman->driver ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pengiriman.show', $pengiriman->id_pengiriman) }}"
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('pengiriman.edit', $pengiriman->id_pengiriman) }}"
                                       class="btn btn-outline-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                @component('components.empty-state', [
                                    'icon' => 'truck',
                                    'title' => 'Belum ada pengiriman',
                                    'actionLabel' => 'Buat Pengiriman',
                                    'actionRoute' => route('pengiriman.create')
                                ])
                                @endcomponent
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($data) && method_exists($data, 'links'))
            <div class="mt-3 d-flex justify-content-end">
                {{ $data->withQueryString()->links() }}
            </div>
        @endif
    @endcomponent

</div>
@endsection
