@extends('layouts.navbar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">Daftar Pesanan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pelanggan</th>
                <th>Catatan</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanans as $pesanan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pesanan->pelanggan->nama }}</td>
                <td>{{ $pesanan->catatan }}</td>
                <td>Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                <td>{{ $pesanan->status }}</td>
                <td>
                    <a href="{{ route('pesanan.show', $pesanan->id_pesanan) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                    <a href="{{ route('pesanan.exportPdf', $pesanan->id_pesanan) }}" class="btn btn-info btn-sm">Ekspor PDF</a>
                    <a href="{{ route('pesanan.edit', $pesanan->id_pesanan) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pesanan.destroy', $pesanan->id_pesanan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Cancel</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection