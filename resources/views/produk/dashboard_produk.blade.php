@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <section class="dashboard-header mb-3">
        <h1>Daftar Produk</h1>
        <p class="text-muted">Manajemen produk UD. Lestari Batako</p>
    </section>

        {{-- Breadcrumb --}}
        <div class="mb-3">
            @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produk', 'url' => route('produk.index')],
                ])
            @endcomponent
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header panel --}}
        <div class=" d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-0"><i class="bi bi-box-seam"></i>Data Produk</h3>
            <div class="d-flex gap-2">
                @can('export produk')
                    <a href="{{ route('produk.export.excel') }}" class="btn btn-outline-secondary btn-sm">Excel</a>
                    <a href="{{ route('produk.export.csv') }}" class="btn btn-outline-secondary btn-sm">CSV</a>
                    <a href="{{ route('produk.export.pdf') }}" class="btn btn-outline-secondary btn-sm">PDF</a>
                @endcan
                <a href="{{ route('produk.create') }}"
                   class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-plus-circle"></i>
                    Tambah
                </a>
            </div>
        </div>

        {{-- Panel --}}
        <section class="panel">

            <div class="panel-body">

                <div class="table-responsive">
                    <table class="table dashboard-table align-middle">
                        <thead>
                            <tr>
                                @php
                                    $cols = [
                                        'id_produk' => 'No',
                                        'nama_produk' => 'Produk',
                                        'gambar_produk' => 'Gambar',
                                        'harga_satuan' => 'Harga',
                                        'stok_tersedia' => 'Stok',
                                        'created_at' => 'Dibuat',
                                    ];
                                    $currentSort = request('sort');
                                    $currentDir = request('direction', 'asc');
                                @endphp
                                @foreach($cols as $key => $label)
                                    <th>
                                        @if(in_array($key, ['gambar_produk']))
                                            {{ $label }}
                                        @else
                                            @php
                                                $nextDir = ($currentSort === $key && $currentDir === 'asc') ? 'desc' : 'asc';
                                                $query = array_merge(request()->query(), ['sort' => $key, 'direction' => $nextDir]);
                                                $url = url()->current() . '?' . http_build_query($query);
                                            @endphp
                                            <a href="{{ $url }}" class="text-decoration-none text-reset">
                                                {{ $label }}
                                                @if($currentSort === $key)
                                                    <i class="bi bi-arrow-{{ $currentDir === 'asc' ? 'up' : 'down' }}-short"></i>
                                                @endif
                                            </a>
                                        @endif
                                    </th>
                                @endforeach
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($KurirData as $produk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $produk->nama_produk }}
                                </td>

                                <td>
                                    @if($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk))
                                        <img src="{{ asset('storage/'.$produk->gambar_produk) }}" class="img-thumbnail" width="56">
                                    @elseif($produk->gambar_produk && file_exists(public_path($produk->gambar_produk)))
                                        <img src="{{ asset($produk->gambar_produk) }}" class="img-thumbnail" width="56">
                                    @elseif($produk->gambar_produk && file_exists(public_path('gambar_produk/'.basename($produk->gambar_produk))))
                                        <img src="{{ asset('gambar_produk/'.basename($produk->gambar_produk)) }}" class="img-thumbnail" width="56">
                                    @else
                                        <img src="{{ asset('gambar_produk/paving-block.png') }}" class="img-thumbnail" width="56">
                                    @endif
                                </td>

                                <td>
                                    Rp {{ number_format($produk->harga_satuan,0,',','.') }}
                                </td>

                                <td>
                                    <span class="badge {{ $produk->stok_tersedia > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $produk->stok_tersedia }}
                                    </span>
                                </td>

                                <td class="text-muted">
                                    {{ optional($produk->created_at)->format('d M Y') }}
                                </td>

                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('produk.show', $produk->id_produk) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('produk.edit', $produk->id_produk) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('produk.delete', $produk->id_produk) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data produk
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination links (server-side) --}}
                <div class="mt-3 d-flex justify-content-end">
                    @if(method_exists($KurirData, 'links'))
                        {{ $KurirData->withQueryString()->links() }}
                    @endif
                </div>

            </div>
        </section>

        {{-- Footer --}}
        <footer class="app-footer">
            &copy; {{ date('Y') }} UD. Lestari Batako
        </footer>

    {{-- Footer --}}
    <footer class="app-footer mt-4">
        &copy; {{ date('Y') }} UD. Lestari Batako
    </footer>

</div>
@endsection
