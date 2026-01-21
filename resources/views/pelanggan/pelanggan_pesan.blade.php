@extends('layouts.app')

@section('content')
<div class="page-container p-fluid">
    <h2 class="mb-4 fw-bold text-primary">Daftar Pelanggan yang Memesan</h2>
    <div class="table-industrial-wrapper">
        <div style="padding: 1.5rem;">
            <div class="table-responsive">
                <table class="table table-industrial striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Tanggal Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($DataPesan as $pesanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pesanan->pelanggan->nama }}</td>
                            <td>{{ $pesanan->produk->nama_produk }}</td>
                            <td>{{ $pesanan->jumlah }}</td>
                            <td>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $pesanan->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection