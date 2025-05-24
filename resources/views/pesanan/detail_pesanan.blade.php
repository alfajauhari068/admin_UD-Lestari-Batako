@extends('layouts.navbar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">Detail Pesanan</h2>

    {{-- Informasi Pesanan Utama --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Pesanan</h5>
            <p><strong>Nama Pelanggan:</strong> {{ $pesanan->pelanggan->nama }}</p>
            <p><strong>Alamat:</strong> {{ $pesanan->pelanggan->alamat }}</p>
            <p><strong>Catatan:</strong> {{ $pesanan->catatan ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $pesanan->status }}</p>
            <p><strong>Total Bayar:</strong> Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Daftar Produk yang Dipesan --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Produk yang Dipesan</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanan->detailPesanan as $index => $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td>Rp{{ number_format($detail->produk->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp{{ number_format($detail->total_bayar, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
