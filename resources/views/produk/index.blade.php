@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Daftar Produk',
        'subtitle' => 'Manajemen produk UD. Lestari Batako',
        'breadcrumbs' => [
            ['label' => 'Produk', 'url' => route('produk.index')]
        ],
        'actions' => '
            <a href="'.route('produk.create').'" class="btn btn-primary btn-sm">
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
                        <th>No</th>
                        <th>Produk</th>
                        <th>Gambar</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($KurirData as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $produk->nama_produk }}</td>
                            <td>
                                @if($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk))
                                    <img src="{{ asset('storage/'.$produk->gambar_produk) }}" class="img-thumbnail" width="56">
                                @elseif($produk->gambar_produk && file_exists(public_path($produk->gambar_produk)))
                                    <img src="{{ asset($produk->gambar_produk) }}" class="img-thumbnail" width="56">
                                @elseif($produk->gambar_produk && file_exists(public_path('gambar_produk/'.basename($produk->gambar_produk))))
                                    <img src="{{ asset('gambar_produk/'.basename($produk->gambar_produk)) }}" class="img-thumbnail" width="56">
                                @else
                                    <img src="{{ asset('gambar_produk/paving-block.png') }}" class="img-thumbnail" width="56">
                                @endif
                            </td>
                            <td>Rp {{ number_format($produk->harga_satuan,0,',','.') }}</td>
                            <td>
                                <span class="badge {{ $produk->stok_tersedia > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $produk->stok_tersedia }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ optional($produk->created_at)->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('produk.show', $produk->id_produk) }}"
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('produk.edit', $produk->id_produk) }}"
                                       class="btn btn-outline-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmModal"
                                            data-action="{{ route('produk.delete', $produk->id_produk) }}"
                                            data-title="Hapus Produk"
                                            data-message="Apakah Anda yakin ingin menghapus produk '{{ $produk->nama_produk }}'?"
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
                                    'icon' => 'box',
                                    'title' => 'Belum ada produk',
                                    'actionLabel' => 'Tambah Produk',
                                    'actionRoute' => route('produk.create')
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
