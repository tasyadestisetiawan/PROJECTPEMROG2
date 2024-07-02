@extends('backend.v_layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Tambah Pembayaran
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pembayaran.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
