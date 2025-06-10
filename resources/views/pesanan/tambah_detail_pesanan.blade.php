@extends('layouts.navbar')

@section('content')
<div class="container py-4 p-5">
    <h2 class="mb-4 mt-5 pt-5 fw-bold text-primary">Tambah Detail Pesanan</h2>
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

            <form action="{{ route('detail_pesanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pesanan" value="{{ $id_pesanan }}">

                <div id="produk-container">
                    <div class="row mb-3 produk-row">
                        <div class="col-md-4">
                            <label for="produk" class="form-label">Produk</label>
                            <select class="form-select produk-select" name="id_produk[]" required>
                                <option value="" selected disabled>Pilih Produk</option>
                                @foreach($produks as $produk)
                                <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga_satuan }}">
                                    {{ $produk->nama_produk }} - Rp{{ number_format($produk->harga_satuan, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control jumlah-input" name="jumlah[]" value="1" min="1" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Detail Pesanan</button>
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection