@extends('layouts.navbar')

@section('content')
<div class="container py-4 p-5 pt-5">
            <div class="mt-5">
            @component('components.breadcrumb')
                    @slot('breadcrumbs', [
                        ['name' => 'Pesanan', 'url' => route('pesanan.index')],
                        ['name' => 'Tambah Pesanan', 'url' => route('pesanan.create')]
                    ])
                @endcomponent
            </div>
    <h4 class="mb-4 mt-2 fw-bold text-primary">Tambah Pesanan</h4>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('pesanan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="id_pelanggan" class="form-label">Pelanggan</label>
                    <select class="form-select" id="id_pelanggan" name="id_pelanggan" required>
                        <option value="" selected disabled>Pilih Pelanggan</option>
                        @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id_pelanggan }}">
                            {{ $pelanggan->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection