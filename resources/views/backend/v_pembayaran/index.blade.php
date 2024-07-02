@extends('backend.v_layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Daftar Pembayaran
                        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary btn-sm float-right">Tambah Pembayaran</a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Pembayaran</th>
                                    <th>Transaksi ID</th>
                                    <th>Nama Customer</th>
                                    <th>Total Harga</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Kembalian</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayarans as $pembayaran)
                                    <tr>
                                        <td>{{ $pembayaran->id }}</td>
                                        <td>{{ $pembayaran->transaksi_id }}</td>
                                        <td>{{ $pembayaran->transaksi->customer->nama_customer }}</td>
                                        <td>Rp {{ number_format($pembayaran->transaksi->total_harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($pembayaran->kembalian ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $pembayaran->created_at->format('d M Y H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                            </form>
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
