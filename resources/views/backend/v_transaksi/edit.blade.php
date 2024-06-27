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
                            <label for="inputPassword4">Nama Customer</label>
                            <input type="text" name="nama_customer" value="{{ old('nama_customer') }}" class="form-control @error('nama_customer') is-invalid @enderror" placeholder="Masukkan Nama Customer">
                            @error('nama_customer')
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
                            <label for="inputPassword4">Total Bayar</label>
                            <input type="text" name="total_bayar" value="{{ old('total_bayar') }}" class="form-control @error('total_bayar') is-invalid @enderror" placeholder="Masukkan Total Bayar">
                            @error('total_bayar')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" placeholder="Masukkan Tanggal">
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