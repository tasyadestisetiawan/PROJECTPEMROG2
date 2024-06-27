@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="col-md-12">
    <div class="card-deck">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">{{ $sub }}</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('transaksi.create') }}" class="btn btn-success">Tambah Transaksi</a>
                </div>
                <div class="table-responsive">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Customer</th>
                                <th>Produk</th>
                                <th>Quantity</th>
                                <th>Berat</th>
                                <th>Subtotal</th>
                                <th>Total Harga</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $index => $trans)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $trans->customer->nama_customer }}</td> <!-- Displaying customer's name -->
                                <td>{{ $trans->produk->nama_produk }}</td>
                                <td>{{ $trans->quantity }}</td>
                                <td>{{ $trans->berat }}</td>
                                <td>{{ $trans->produk->harga }}</td> <!-- Displaying unit price from product -->
                                <td>{{ $trans->total_harga }}</td> <!-- Displaying total price -->
                                <td>{{ $trans->tanggal }}</td>
                                <td>
                                    <a href="{{ route('transaksi.edit', $trans->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('transaksi.destroy', $trans->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
<!-- template end -->
@endsection
