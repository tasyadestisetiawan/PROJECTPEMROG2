@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('transaksi.update', $edit->id) }}" method="post" class="form-horizontal">
                @method('put')
                @csrf

                <div class="card-body">
                    <h4 class="card-title">{{ $sub }}</h4>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="customer_id">Nama Customer</label>
                            <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                                <option value="" selected>--Pilih Customer--</option>
                                @foreach ($customers as $cust)
                                <option value="{{ $cust->id }}" {{ $edit->customer_id == $cust->id ? 'selected' : '' }}> {{ $cust->nama_customer }} </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="produk_id">Produk</label>
                            <select class="form-control @error('produk_id') is-invalid @enderror" name="produk_id">
                                <option value="" selected>--Pilih Produk--</option>
                                @foreach ($produk as $row)
                                <option value="{{ $row->id }}" {{ $edit->produk_id == $row->id ? 'selected' : '' }}> {{ $row->nama_produk }} </option>
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
                            <input type="number" name="quantity" value="{{ $edit->quantity }}" class="form-control @error('quantity') is-invalid @enderror" placeholder="Masukkan Quantity">
                            @error('quantity')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ $edit->tanggal }}" class="form-control @error('tanggal') is-invalid @enderror" placeholder="Masukkan Tanggal">
                            @error('tanggal')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success text-white">
                            Perbaharui
                        </button>
                        <a href="{{ route('transaksi.index') }}">
                            <button type="button" class="btn btn-danger">
                                Kembali
                            </button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- template end-->
@endsection
