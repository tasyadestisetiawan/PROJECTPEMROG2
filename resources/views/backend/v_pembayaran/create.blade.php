@extends('backend.v_layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Tambah Pembayaran
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pembayaran.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="transaksi_id" value="{{ request()->query('transaksi_id') }}">
                            <div class="form-group">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" step="0.01" min="0" required>
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
