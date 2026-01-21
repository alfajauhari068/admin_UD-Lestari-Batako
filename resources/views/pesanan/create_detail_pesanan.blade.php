@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="mb-5 fw-bold text-primary">Tambah Produk ke Pesanan</h2>
    <div class="card custom-card max-w-900">
        <div class="card-body p-0">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('detail_pesanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">
                <div id="product-rows">
                            <div class="product-row mb-4 d-flex gap-2 align-items-start">
                            <div class="flex-grow-1">
                                <label class="form-label fw-semibold">Produk *</label>
                                <select class="form-select form-control" name="id_produk[]" required>
                                <option value="" selected disabled>Pilih Produk</option>
                                @foreach($produks as $produk)
                                <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }} - Rp{{ number_format($produk->harga_satuan, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-shrink-0">
                            <label class="form-label fw-semibold">Jumlah *</label>
                            <input type="number" class="form-control" name="jumlah[]" value="1" min="1" required>
                        </div>

                        <div class="flex-shrink-0 d-flex align-items-start">
                            <button type="button" class="btn btn-danger btn-remove-row d-none">&times;</button>
                        </div>
                    </div>
                </div>

                    <div class="mb-4">
                    <button type="button" id="add-row" class="btn btn-outline-primary">Tambah Produk Lain</button>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                    <a href="{{ route('pesanan.detail', $pesanan->id_pesanan) }}" class="btn btn-secondary-custom">
                        <i class="bi bi-arrow-left-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('product-rows');
        const addBtn = document.getElementById('add-row');

        addBtn.addEventListener('click', function () {
            const first = container.querySelector('.product-row');
            const clone = first.cloneNode(true);
            // reset values
            clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
            clone.querySelectorAll('input').forEach(i => { if(i.type === 'number') i.value = 1; });
            // show remove button
            clone.querySelectorAll('.btn-remove-row').forEach(b => { b.style.display = 'inline-block'; });
            container.appendChild(clone);
            attachRemoveHandlers();
        });

        function attachRemoveHandlers() {
            container.querySelectorAll('.btn-remove-row').forEach(btn => {
                if (!btn.dataset.bound) {
                    btn.addEventListener('click', function (e) {
                        const row = e.target.closest('.product-row');
                        if (row) row.remove();
                    });
                    btn.dataset.bound = '1';
                }
            });
        }

        attachRemoveHandlers();
    });
</script>
@endsection