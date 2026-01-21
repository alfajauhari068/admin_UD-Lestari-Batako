@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Detail Tim Produksi</h2>
    <table class="table table-bordered">
        <tr>
            <th>Nama Produksi</th>
            <td>{{ $produksiKaryawan->produksi->produk->nama_produk ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Tanggal Produksi</th>
            <td>{{ $produksiKaryawan->tanggal_produksi }}</td>
        </tr>
        <tr>
            <th>Jumlah Unit</th>
            <td>{{ $produksiKaryawan->jumlah_unit }}</td>
        </tr>
    </table>

    <h4 class="mt-4">Anggota Tim</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Upah Diterima</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produksiKaryawan->tim as $tim)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tim->karyawan->nama }}</td>
                <td>
                    @if(isset($produksiKaryawan->upah_per_karyawan) && $produksiKaryawan->upah_per_karyawan > 0)
                        Rp{{ number_format($produksiKaryawan->upah_per_karyawan, 0, ',', '.') }}
                    @else
                        <span class="text-muted">Belum dihitung</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-secondary mt-3">Kembali ke Tim Produksi</a>
</div>
@endsection