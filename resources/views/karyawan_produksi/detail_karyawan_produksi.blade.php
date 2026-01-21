@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5" style="padding-top: 80px;">
    <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Tim Produksi', 'url' => route('karyawan_produksi.index')],
                    ['name' => 'Detail Tim Produksi', 'url' => route('karyawan_produksi.create')]
                ])
            @endcomponent
    </div>
    <h2 class="mb-4">Detail Upah Produksi</h2>
    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($produksiKaryawan->tanggal_produksi)->format('d M Y') }}</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Nama Produksi</th>
                <th>Jumlah Unit</th>
                <th>Upah Diterima</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produksiKaryawan->tim as $tim)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tim->karyawan->nama }}</td>
                <td>{{ $produksiKaryawan->produksi->produk->nama_produk ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $tim->jumlah_unit }}</td>
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
    <div class="mt-4">
        <h5>Total Jumlah Unit: {{ $total_unit ?? $produksiKaryawan->total_unit ?? 0 }}</h5>
    </div>
    <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection