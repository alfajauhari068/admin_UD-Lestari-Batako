@extends('layouts.app')

@section('title', 'Detail Produksi')

@section('content')
<div class="container-fluid py-4">

    @component('components.page-header', [
        'title' => 'Detail Produksi',
        'subtitle' => 'Informasi lengkap produksi',
        'breadcrumbs' => [
            ['label' => 'Produksi', 'url' => route('produksi.index')],
            ['label' => 'Detail']
        ]
    ])
    @endcomponent

    <div class="row">
        <div class="col-md-8">
            @component('components.card', ['title' => 'Informasi Produksi'])
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Produk</label>
                            <p class="mb-0">{{ $produksi->produk->nama_produk ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Tanggal Produksi</label>
                            <p class="mb-0">{{ $produksi->tanggal_produksi?->format('d M Y') ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Jumlah Produksi</label>
                            <p class="mb-0">{{ number_format($produksi->jumlah) }} unit</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Status</label>
                            <p class="mb-0">
                                <span class="badge {{ $produksi->status === 'selesai' ? 'bg-success' : ($produksi->status === 'dibatalkan' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($produksi->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                @if(isset($tanggalCarbon))
                <hr class="my-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Tanggal Detail</label>
                            <p class="mb-0">{{ Carbon\Carbon::parse($tanggalCarbon)->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Total Unit Diproduksi</label>
                            <p class="mb-0">{{ isset($total_unit) ? number_format($total_unit) : '0' }} unit</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Jumlah Anggota Tim</label>
                            <p class="mb-0">{{ isset($jumlah_anggota) ? $jumlah_anggota : '0' }} orang</p>
                        </div>
                    </div>
                </div>
                @endif
            @endcomponent
        </div>

        <div class="col-md-4">
            @component('components.card', ['title' => 'Aksi'])
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('produksi.edit', $produksi->id_produksi) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil me-2"></i>Edit
                    </a>
                    @if(auth()->check())
                    <form action="{{ route('produksi.destroy', $produksi->id_produksi) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus?')">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('produksi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            @endcomponent
        </div>
    </div>

</div>
@endsection
