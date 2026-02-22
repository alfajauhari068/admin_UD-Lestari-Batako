@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mt-4">
            @component('components.breadcrumb')
            @slot('breadcrumbs', [
                ['name' => 'Produksi Karyawan Tim', 'url' => route('produksi_karyawan_tim.index')],
                ['name' => 'Detail Anggota', 'url' => '#']
            ])
        @endcomponent
    </div>

    <h2 class="mb-4">Detail Anggota</h2>

    <div class="card shadow-sm p-4 mb-4">
        <table class="table table-borderless">
            <tr>
                <th>Nama Karyawan</th>
                <td>{{ $produksiKaryawanTim->karyawan->nama ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Jumlah Unit</th>
                <td>{{ $produksiKaryawanTim->jumlah_unit }}</td>
            </tr>
            <tr>
                <th>Tanggal Produksi</th>
                <td>{{ \Carbon\Carbon::parse($produksiKaryawanTim->tanggal_produksi)->format('d M Y') }}</td>
            </tr>
        </table>

        <div class="mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
