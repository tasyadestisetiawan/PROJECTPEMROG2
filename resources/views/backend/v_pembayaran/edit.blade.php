@extends('backend.v_layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Edit Pembayaran
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="transaksi_id">ID Transaksi</label>
                                <input type="text" class="form-control" id="transaksi_id" name="transaksi_id" value="{{ $pembayaran->transaksi_id }}" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" value="{{ $pembayaran->jumlah_bayar }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{route('pembayaran.index')}}"><button type="button" class="btn btn-danger">Kembali</button> </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
