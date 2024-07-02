<!-- backend/transaksi/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        /* Define your styles for the PDF here */
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Produk</th>
                <th>Quantity</th>
                <th>Berat Satuan</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $trans)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $trans->customer->nama_customer }}</td>
                <td>{{ $trans->produk->nama_produk }}</td>
                <td>{{ $trans->quantity }}</td>
                <td>{{ $trans->berat }}</td>
                <td>{{ $trans->produk->harga }}</td>
                <td>{{ $trans->total_harga }}</td>
                <td>{{ $trans->tanggal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
