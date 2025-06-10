@extends('layouts.navbar')

@section('content')
<div class="container py-4 p-5">
    <div class="mt-5 pt-5">
            @component('components.breadcrumb')
                    @slot('breadcrumbs', [
                        ['name' => 'Pesanan', 'url' => route('pesanan.index')],
                        ['name' => 'Tambah Pesanan', 'url' => route('pesanan.create')]
                    ])
                @endcomponent
            </div>
            <div class="col-auto">
                <h4 class="fw-bold text-primary">Detail Pesanan</h4>
            </div>

    {{-- Informasi Pesanan Utama --}}
    <div class="card mb-4 shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-primary">Informasi Pesanan</h5>
            <p><strong>Nama Pelanggan:</strong> {{ $pesanan->pelanggan->nama ?? 'Tidak Diketahui' }}</p>
            <p><strong>Alamat:</strong> {{ $pesanan->pelanggan->alamat ?? 'Tidak Diketahui' }}</p>
            <p><strong>Catatan:</strong> {{ $pesanan->catatan ?? '-' }}</p>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($pesanan->status == 'Selesai') bg-success 
                    @elseif($pesanan->status == 'Dikirim') bg-warning 
                    @else bg-secondary 
                    @endif">
                    {{ $pesanan->status ?? 'Diproses' }}
                </span>
            </p>
            <p><strong>Total Bayar:</strong> Rp{{ number_format($pesanan->detailPesanan->sum('total_bayar'), 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Daftar Produk yang Dipesan --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-bold text-primary">Produk yang Dipesan</h5>
                <div class="col-auto">
                <a href="{{ route('detail_pesanan.create', $pesanan->id_pesanan) }}" class="btn btn-primary rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
                    <i class="bi bi-plus-circle fs-4"></i>
                </a>
                </div>
                
            </div>
            <table class="table table-hover table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pesanan->detailPesanan && $pesanan->detailPesanan->count() > 0)
                        @foreach($pesanan->detailPesanan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->id_produk->nama_produk ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('detail_pesanan.edit', $item->id_detail_pesanan) }}" 
                                           class="btn btn-warning btn-sm rounded-pill shadow-sm d-flex align-items-center gap-1" 
                                           data-bs-toggle="tooltip" title="Edit Detail">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('detail_pesanan.destroy', $item->id_detail_pesanan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm rounded-pill shadow-sm d-flex align-items-center gap-1" 
                                                    onclick="return confirm('Yakin ingin menghapus produk ini?')" 
                                                    data-bs-toggle="tooltip" title="Hapus Produk">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada produk yang dipesan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary rounded-pill shadow-sm mt-3">Kembali</a>
</div>
@endsection
