@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mt-4">
            @component('components.breadcrumb')
            @slot('breadcrumbs', [
                ['name' => 'Produksi Karyawan Tim', 'url' => route('produksi_karyawan_tim.index')],
                ['name' => 'Edit Anggota', 'url' => '#']
            ])
        @endcomponent
    </div>

    <h2 class="mb-4">Edit Anggota Tim</h2>

    <div class="card shadow-sm p-4 mb-4">
        <form action="{{ route('produksi_karyawan_tim.update', ['produksi_karyawan_tim' => $produksiKaryawanTim->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Karyawan</label>
                <select name="id_karyawan" class="form-control" required>
                    @foreach($karyawans as $k)
                        <option value="{{ $k->id_karyawan }}" {{ $produksiKaryawanTim->id_karyawan == $k->id_karyawan ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Unit</label>
                <input type="number" name="jumlah_unit" class="form-control" value="{{ $produksiKaryawanTim->jumlah_unit }}" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Produksi</label>
                <input type="date" name="tanggal_produksi" class="form-control" value="{{ \Carbon\Carbon::parse($produksiKaryawanTim->tanggal_produksi)->format('Y-m-d') }}" required>
            </div>

            <button class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
