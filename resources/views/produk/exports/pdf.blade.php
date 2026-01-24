<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Produk</title>
    <style>
        body{font-family: DejaVu Sans, sans-serif; font-size:12px}
        table{width:100%; border-collapse:collapse}
        th, td{border:1px solid #ddd; padding:6px}
        th{background:#f4f4f4}
    </style>
</head>
<body>
    <h3>Daftar Produk</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
        @foreach($produks as $p)
            <tr>
                <td>{{ $p->id_produk }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td>{{ $p->harga_satuan }}</td>
                <td>{{ $p->stok_tersedia }}</td>
                <td>{{ optional($p->created_at)->format('d M Y H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>