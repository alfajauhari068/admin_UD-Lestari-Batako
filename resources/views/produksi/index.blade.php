@extends('layouts.app')

@section('title', 'Daftar Produksi')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Daftar Produksi',
        'subtitle' => 'Manajemen produksi UD. Lestari Batako',
        'breadcrumbs' => [
            ['label' => 'Produksi', 'url' => route('produksi.index')]
        ],
        'actions' => '
            <a href="'.route('produksi.create').'" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Baru
            </a>
        '
    ])
    @endcomponent

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @component('components.card')
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Produk</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produksis as $produksi)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $produksi->produk->nama_produk ?? '-' }}</td>
                            <td>{{ $produksi->tanggal_produksi?->format('d M Y') ?? '-' }}</td>
                            <td>{{ number_format($produksi->jumlah) }} unit</td>
                            <td>
                                <span class="badge {{ $produksi->status === 'selesai' ? 'bg-success' : ($produksi->status === 'dibatalkan' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($produksi->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('produksi.show', $produksi->id_produksi) }}"
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('produksi.edit', $produksi->id_produksi) }}"
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
                                    'icon' => 'gear-wide-connected',
                                    'title' => 'Belum ada produksi',
                                    'actionLabel' => 'Buat Produksi',
                                    'actionRoute' => route('produksi.create')
                                ])
                                @endcomponent
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($produksis) && method_exists($produksis, 'links'))
            <div class="mt-3 d-flex justify-content-end">
                {{ $produksis->withQueryString()->links() }}
            </div>
        @endif
    @endcomponent

</div>
@endsection
