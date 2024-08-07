@extends('backend.v_layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Daftar Pembayaran
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th><h6>ID Bayar</h6></th>
                                    <th><h6>ID Trans</h6></th>
                                    <th><h6>Nama Cust</h6></th>
                                    <th><h6>Nama Produk</h6></th>
                                    <th><h6>Total Harga</h6></th>
                                    <th><h6>Jumlah Bayar</h6></th>
                                    <th><h6>Kembalian</h6></th>
                                    <th><h6>Tgl Pembayaran</h6></th>
                                    <th><h6>Nama Admin</h6></th>
                                    <th><h6>Aksi</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksis as $transaksi)
                                    @php
                                        $pembayaran = $transaksi->pembayaran;
                                    @endphp
                                    <tr>
                                        <td>{{ $pembayaran ? $pembayaran->id : '-' }}</td>
                                        <td>{{ $transaksi->id }}</td>
                                        <td>{{ $transaksi->customer->nama_customer }}</td>
                                        <td>{{ $transaksi->produk->nama_produk }}</td>
                                        <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $pembayaran ? 'Rp ' . number_format($pembayaran->jumlah_bayar, 0, ',', '.') : '-' }}</td>
                                        <td>{{ $pembayaran ? 'Rp ' . number_format($pembayaran->kembalian, 0, ',', '.') : '-' }}</td>
                                        <td>{{ $pembayaran ? $pembayaran->created_at : '-' }}</td>
                                        <td>{{ $transaksi->user->nama }}</td>
                                        <td>
                                            @if ($pembayaran)
                                                <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            @else
                                                <a href="{{ route('pembayaran.create', ['transaksi_id' => $transaksi->id]) }}" class="btn btn-primary btn-sm @if ($pembayaran) disabled @endif" @if ($pembayaran) disabled="disabled" aria-disabled="true" tabindex="-1" @endif>Bayar</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
