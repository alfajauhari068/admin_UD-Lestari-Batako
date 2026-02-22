@extends('layouts.app')

@section('content')
<div class="container p-5 mt-5">
    <h2 class="mb-4">Laporan Produksi Karyawan</h2>

    <!-- Filter -->
    <form method="GET" action="{{ route('produksi_karyawan_tim.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="tanggal" class="form-label">Tanggal Produksi</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-4">
                <label for="karyawan_id" class="form-label">Karyawan</label>
                <select name="karyawan_id" id="karyawan_id" class="form-control">
                    <option value="">Semua Karyawan</option>
                    @foreach($karyawans as $karyawan)
                        <option value="{{ $karyawan->id_karyawan }}" {{ request('karyawan_id') == $karyawan->id_karyawan ? 'selected' : '' }}>
                            {{ $karyawan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Tanggal Produksi</th>
                <th>Jumlah Produksi</th>
                <th>Upah Individu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->karyawan->nama }}</td>
                    <td>{{ $item->produksi->tanggal_produksi }}</td>
                    <td>{{ $item->produksi->jumlah_produksi }}</td>
                    <td>Rp{{ number_format($item->upah_individu, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection