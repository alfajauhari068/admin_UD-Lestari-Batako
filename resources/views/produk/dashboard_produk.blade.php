{{-- Backward Compatibility Alias - Uses $KurirData from controller --}}
@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
            <div>
                <h1 class="page-title h3 mb-1">Daftar Produk</h1>
                <p class="text-muted mb-0">Manajemen produk UD. Lestari Batako</p>
            </div>
            <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah
            </a>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Data Card --}}
    <div class="card custom-card">
        <div class="card-body">
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
                                        <form action="{{ route('produk.delete', $produk->id_produk) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data produk
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
        </div>
    </div>

    <footer class="app-footer mt-4 py-3 text-center text-muted small">
        <span>&copy; {{ date('Y') }} UD. Lestari Batako</span>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
