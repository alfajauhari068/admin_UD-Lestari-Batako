@extends('layouts.navbar')

@section('content')
<div class="container py-5 mt-5">
    <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produksi Karyawan', 'url' => route('karyawan_produksi.index')],
                    ['name' => 'Detail Produksi Karyawan', 'url' => route('karyawan_produksi.create')]
                ])
            @endcomponent
    </div>
    <h2 class="mb-4">Detail Produksi Karyawan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Nama Produksi</th>
                <th>Upah Per Karyawan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produksiKaryawan->tim as $tim)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tim->karyawan->nama }}</td>
                <td>{{ $produksiKaryawan->produksi->nama_produksi }}</td>
                <td>Rp{{ number_format($produksiKaryawan->upah_total / $produksiKaryawan->tim->count(), 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        <h5>Total Jumlah Unit: {{ $jumlahUnit }}</h5>
        <h5>Total Upah Keseluruhan: Rp{{ number_format($upahTotalKeseluruhan, 0, ',', '.') }}</h5>
    </div>
    <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection