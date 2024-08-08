@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Detail Pembayaran
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th><h6>ID Bayar</h6></th>
                            <td>{{ $pembayaran->id }}</td>
                        </tr>
                        <tr>
                            <th><h6>ID Transaksi</h6></th>
                            <td>{{ $pembayaran->transaksi_id }}</td>
                        </tr>
                        <tr>
                            <th><h6>Nama Customer</h6></th>
                            <td>{{ $pembayaran->transaksi->customer->nama_customer }}</td>
                        </tr>
                        <tr>
                            <th><h6>Nama Produk</h6></th>
                            <td>{{ $pembayaran->transaksi->produk->nama_produk }}</td>
                        </tr>
                        <tr>
                            <th><h6>Total Harga</h6></th>
                            <td>Rp {{ number_format($pembayaran->transaksi->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th><h6>Jumlah Bayar</h6></th>
                            <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th><h6>Kembalian</h6></th>
                            <td>Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th><h6>Tanggal Pembayaran</h6></th>
                            <td>{{ $pembayaran->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th><h6>Nama Admin</h6></th>
                            <td>{{ $pembayaran->user->nama }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
