{{-- filepath: d:\KULIAH\Semester4\Interaksi Manusia dan Komputer\tugas-3\ud_lestari-batako\resources\views\pesanan\detail_pesanan_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            color: #333;
        }
        h2, h3 {
            color: #007bff;
        }
        p {
            font-size: 14px;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        th {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        td {
            padding: 8px;
            text-align: left;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <h2>Detail Pesanan</h2>
    <p><strong>Nama Pelanggan:</strong> {{ $pesanan->pelanggan->nama }}</p>
    <p><strong>Alamat:</strong> {{ $pesanan->pelanggan->alamat }}</p>
    <p><strong>Catatan:</strong> {{ $pesanan->catatan ?? '-' }}</p>
    <p><strong>Status:</strong> {{ $pesanan->status }}</p>
    <p><strong>Total Bayar:</strong> Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>

    <h3>Produk yang Dipesan</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan->detailPesanan as $index => $detail)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $detail->produk->nama_produk }}</td>
                <td>Rp{{ number_format($detail->produk->harga_satuan, 0, ',', '.') }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp{{ number_format($detail->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>