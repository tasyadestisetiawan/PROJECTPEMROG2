@extends('backend.v_layouts.app')
@section('content')
<!-- template -->
<div class="col-md-12">
    <div class="card-deck">
        <div class="card shadow mb-4">
            <form action="{{ route('transaksi.store') }}" method="post" class="form-horizontal">
                @csrf
                <div class="card-header">
                    <strong class="card-title"> {{$sub}} </strong>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="customer_id">Nama Customer</label>
                            <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id">
                                <option value="" selected>--Pilih Customer--</option>
                                @foreach ($customer as $cust)
                                <option value="{{ $cust->id }}"> {{ $cust->nama_customer }} </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label>Produk</label>
                            <select class="form-control @error('produk_id') is-invalid @enderror" name="produk_id">
                                <option value="" selected>--Pilih Produk--</option>
                                @foreach ($produk as $row)
                                <option value="{{ $row->id }}"> {{ $row->nama_produk }} </option>
                                @endforeach
                            </select>
                            @error('produk_id')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control @error('quantity') is-invalid @enderror" placeholder="Masukkan Quantity">
                            @error('quantity')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" placeholder="Masukkan Tanggal">
                            @error('tanggal')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"> Simpan </button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-danger"> Kembali </a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- template end -->
@endsection