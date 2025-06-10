<center><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets\bootstrap-5.3.6-dist\js\bootstrap.bundle.min.js"></script>
    <title>UD.Lestari Batako</title>
</head>
<body>
<script src="/js/bootstrap.bundle.min.js"></script>
@extends('layouts.navbar')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar') <!-- Sidebar -->
    <div class="container-fluid py-4 p-5" style="background: linear-gradient(to right, #f8f9fa, #e9ecef); min-height: 100vh; margin-left: 250px;"> <!-- Konten utama -->
        <div class="container py-4">
        <!-- Breadcrumb -->
        <div class="mt-5">
            @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produk', 'url' => route('produk.index')],
                ])
            @endcomponent
        </div>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Header dan Tombol Tambah -->
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-auto">
                <h4 class="fw-bold text-primary">Daftar Produk</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('produk.create') }}" 
                   class="btn btn-primary btn-floating rounded-circle" 
                   data-mdb-ripple-init 
                   style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
                    <i class="bi bi-plus-circle fs-4"></i>
                </a>
            </div>
        </div>

        <!-- Tabel Produk -->
        <div class="docs-table">
            <table class="table table-hover align-middle" data-toggle="table" data-show-toggle="true" data-show-columns="true" data-search="true" data-striped="true">
                <thead class="table-light">
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Nama Produk</center></th>
                        <th><center>Gambar</center></th>
                        <th><center>Harga</center></th>
                        <th><center>Stok</center></th>
                        <th><center>Dibuat</center></th>
                        <th><center>Diupdate</center></th>
                        <th><center>Aksi</center></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($KurirData as $produk)
                    <tr>
                        <td><center>{{ $loop->iteration }}</center></td>
                        <td class="fw-semibold"><center>{{ $produk->nama_produk }}</center></td>
                        <td><center>
                            @if($produk->gambar_produk)
                                <img src="{{ asset('storage/'.$produk->gambar_produk) }}" alt="Gambar Produk" 
                                width="60" 
                                class="img-thumbnail"
                                style="cursor: pointer;"
                                onclick="showImagePreview('{{ asset('storage/' . $produk->gambar_produk) }}')">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </center></td>
                        <td><center>Rp{{ number_format($produk->harga_satuan, 0, ',', '.') }}</center></td>
                        <td><center>
                            <span class="badge bg-{{ $produk->stok_tersedia > 0 ? 'success' : 'danger' }}">
                                {{ $produk->stok_tersedia }}
                            </span>
                        </center></td>
                        <td><center>
                            <span class="text-secondary" title="{{ $produk->created_at }}">
                                {{ $produk->created_at ? $produk->created_at->format('d M Y H:i') : '-' }}
                            </span>
                        </td>
                        <td><center>
                            <span class="text-secondary" title="{{ $produk->updated_at }}">
                                {{ $produk->updated_at ? $produk->updated_at->format('d M Y H:i') : '-' }}
                            </span>
                        </center></td>
                        <td><center>
                            <div class="d-flex gap-2 justify-content-center">
                                <!-- Tombol Detail -->
                                <a href="{{ route('produk.show', $produk->id_produk) }}" 
                                   class="btn btn-primary btn-sm d-flex align-items-center gap-1" 
                                   data-mdb-ripple-init role="button" 
                                   data-bs-toggle="tooltip" title="Lihat Detail Produk">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- Tombol Edit -->
                                <button class="btn btn-primary btn d-flex align-items-center gap-1 rounded-circle" 
                                        data-mdb-ripple-init type="button" 
                                        onclick="window.location.href='{{ route('produk.edit', $produk->id_produk) }}'" 
                                        data-bs-toggle="tooltip" title="Edit Produk"
                                        style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                                    <i class="bi bi-pencil-square fs-6"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <button class="btn btn-danger btn d-flex align-items-center gap-1 rounded-circle"
                                            data-mdb-ripple-init type="submit"
                                            onclick="return confirm('Yakin hapus produk ini?')"
                                            data-bs-toggle="tooltip" title="Hapus Produk"
                                            style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                                        <i class="bi bi-trash fs-6"></i>
                                <form action="{{ route('produk.delete', $produk->id_produk) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    </button>
                                </form>
                            </div>
                        </center></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
    </div>
</div>
</body>
<script>
    function showImagePreview(imageUrl) {
        // Set src pada elemen gambar di modal
        document.getElementById('previewImage').src = imageUrl;

        // Tampilkan modal
        var imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        imagePreviewModal.show();
    }

    // Fungsi untuk mengaktifkan navigasi
    function activateNav() {
        $('ul.nav > li').on('click', function (evt) {
            if ($(evt.currentTarget).hasClass('toggle-nav')) return;
            $(evt.currentTarget).addClass('active').siblings().removeClass('active');
        });
    }

    // Data dokumen
    var docs = [
        {
            "Type": "excel",
            "Name": "Remaining tasks for this app",
            "Description": "This is a list of all the remaining tasks required to complete this app",
            "Tags": "Responsive, RWD",
            "LastViewed": "an hour ago",
            "Expiration": "Sep 17, 2015"
        },
        {
            "Type": "ppt",
            "Name": "EVAMs presentation",
            "Description": "This is presentation for the EVAM occuring later this month",
            "Tags": "EVAM",
            "LastViewed": "a day ago",
            "Expiration": "Sep 08, 2015"
        },
        {
            "Type": "word",
            "Name": "Xmas Party list",
            "Description": "List of all the people who will be attending the holiday party",
            "Tags": "Responsive, RWD",
            "LastViewed": "a few mins ago",
            "Expiration": "Dec 25, 2014"
        }
    ];

    // Fungsi untuk menambahkan toggle pada sidebar
    function addToggle() {
        $('li.toggle-nav').on('click', function () {
            $(this).find('i').toggleClass('rotate-180-deg');
            $('.navbar-nav.side-nav').toggleClass('hide-link-text');
            $('#wrapper').toggleClass('expanded');
        });
    }

    // Fungsi untuk memperbaiki hamburger menu
    function fixHamburgerUl() {
        $('.navbar-toggle').on('click', function () {
            $('.navbar-nav.side-nav').removeClass('hide-link-text');
            $("#wrapper").removeClass('expanded');
            $('i.fa-arrow-left').removeClass('rotate-180-deg');
        });
    }

    // Inisialisasi fungsi
    function init() {
        activateNav();
        addToggle();
        fixHamburgerUl();
    }

    // Panggil fungsi init
    init();
</script>
</html>