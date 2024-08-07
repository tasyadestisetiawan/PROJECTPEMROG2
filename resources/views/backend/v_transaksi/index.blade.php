@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <div class="header clearfix">
        <form action="{{ route('transaksi.print') }}" method="POST" class="form-inline float-end">
            @csrf
            <div class="row gx-3 align-items-center">
                <div class="col-auto">
                    <label for="date" class="sr-only">Date</label>
                    <input type="date" class="form-control" id="date" name="date" placeholder="Select Date">
                </div>
                <div class="col-auto">
                    <label for="month" class="sr-only">Month</label>
                    <input type="month" class="form-control" id="month" name="month" placeholder="Select Month">
                </div>
                <div class="col-auto">
                    <label for="year" class="sr-only">Year</label>
                    <input type="number" class="form-control" id="year" name="year" placeholder="Select Year">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>
            </div>
        </form>

        <a href="{{ route('transaksi.create') }}" class="btn btn-success mb-2 float-start">
            <i class="bi bi-plus-lg"></i> Tambah Transaksi
        </a>
    </div>

    <div class="card shadow mb-4 mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <h6>No</h6>
                                </th>
                                <th>
                                    <h6>Nama Customer</h6>
                                </th>
                                <th>
                                    <h6>Produk</h6>
                                </th>
                                <th>
                                    <h6>Nama Admin</h6>
                                </th>
                                <th>
                                    <h6>Gambar Produk</h6>
                                </th>
                                <th>
                                    <h6>QTY</h6>
                                </th>
                                <th>
                                    <h6>Berat Satuan</h6>
                                </th>
                                <th>
                                    <h6>Harga Satuan</h6>
                                </th>
                                <th>
                                    <h6>Total Harga</h6>
                                </th>
                                <th>
                                    <h6>Tanggal</h6>
                                </th>
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $index => $trans)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $trans->customer->nama_customer }}</td>
                                <td>{{ $trans->produk->nama_produk }}</td>
                                <td>{{ $trans->user->nama }}</td>
                                <td>
                                    @if ($trans->produk->gambar)
                                    <img src="{{ asset('storage/' . $trans->produk->gambar) }}" alt="{{ $trans->produk->nama_produk }}" style="max-width: 100px; max-height: 100px;">
                                    @else
                                    No image
                                    @endif
                                </td>
                                <td>{{ $trans->quantity }}</td>
                                <td>{{ $trans->berat }}</td>
                                <td>{{ 'Rp ' . number_format($trans->produk->harga, 0, ',', '.') }}</td>
                                <td>{{ 'Rp ' . number_format($trans->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $trans->tanggal }}</td>
                                <td>
                                    @if ($trans->pembayaran)
                                    <span>Transaksi sudah dibayar</span>
                                    @else
                                    <a href="{{ route('transaksi.edit', $trans->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('transaksi.destroy', $trans->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                    </form>
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
    @endsection