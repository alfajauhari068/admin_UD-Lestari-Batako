@extends('layouts.navbar')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Detail Produksi</h2>
    <table class="table table-bordered">
        <tr>
            <th>Nama Produksi</th>
            <td>{{ $produksiKaryawan->produksi->nama_produksi }}</td>
        </tr>
        <tr>
            <th>Tanggal Produksi</th>
            <td>{{ $produksiKaryawan->tanggal_produksi }}</td>
        </tr>
        <tr>
            <th>Jumlah Unit</th>
            <td>{{ $produksiKaryawan->jumlah_unit }}</td>
        </tr>
        <tr>
            <th>Upah Total</th>
            <td>Rp{{ number_format($produksiKaryawan->upah_total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <h4 class="mt-4">Anggota Tim</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Upah Per Karyawan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produksiKaryawan->tim as $tim)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tim->karyawan->nama }}</td>
                <td>Rp{{ number_format($produksiKaryawan->upah_total / $produksiKaryawan->tim->count(), 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection