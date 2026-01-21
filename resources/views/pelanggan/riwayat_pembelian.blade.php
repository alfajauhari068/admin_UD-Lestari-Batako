@extends('layouts.app')

@section('content')
<div class="container py-4 p-5 mt-5">
    <h2 class="mb-4 mt-5 fw-bold text-primary">Riwayat Pembelian - {{ $pelanggan->nama }}</h2>

    {{-- Informasi Pelanggan --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Pelanggan</h5>
            <p><strong>Nama:</strong> {{ $pelanggan->nama }}</p>
            <p><strong>Email:</strong> {{ $pelanggan->email ?? '-' }}</p>
            <p><strong>No HP:</strong> {{ $pelanggan->no_hp ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $pelanggan->alamat ?? '-' }}</p>
        </div>
    </div>

    {{-- Riwayat Pesanan --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Riwayat Pesanan</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Pesanan</th>
                        <th>Status</th>
                        <th>Total Bayar</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggan->pesanans as $pesanan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pesanan->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $pesanan->status }}</td>
                        <td>Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            <ul>
                                @foreach ($pesanan->detailPesanan as $catatan)
                                    <li>{{ $catatan->produk->nama_produk ?? 'Tidak Diketahui' }} - {{ $catatan->jumlah }} pcs</li>
                                    @if(!empty($catatan->catatan))
                                        <small class="text-muted">Catatan: {{ $catatan->catatan }}</small>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada riwayat pembelian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection