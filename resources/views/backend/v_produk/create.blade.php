@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="col-md-12">
    <div class="card-deck">
        <div class="card shadow mb-4">
            <form action="{{ route('produk.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf

                <div class="card-header">
                    <strong class="card-title"> {{$sub}} </strong>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Kategori</label>
                            <select class="form-control @error('kategori_id') is-invalid @enderror" name="kategori_id">
                                <option value="" selected>--Pilih Kategori--</option>
                                @foreach ($kategori as $row)
                                    <option value="{{ $row->id }}"> {{ $row->nama_kategori }} </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Nama produk</label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="form-control @error('nama_produk') is-invalid @enderror" placeholder="Masukkan nama produk">
                            @error('nama_produk')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Berat</label>
                            <input type="text" name="berat" value="{{ old('berat') }}" class="form-control @error('berat') is-invalid @enderror" placeholder="Masukkan Berat">
                            @error('berat')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Satuan</label>
                            <input type="text" name="satuan" value="{{ old('satuan') }}" class="form-control @error('satuan') is-invalid @enderror" placeholder="Masukkan Satuan">
                            @error('satuan')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Harga</label>
                            <input type="text" name="harga" value="{{ old('harga') }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan Harga">
                            @error('harga')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Stok</label>
                            <input type="text" name="stok" value="{{ old('stok') }}" class="form-control @error('stok') is-invalid @enderror" placeholder="Masukkan Stok">
                            @error('stok')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="gambar">Gambar</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
                            @error('gambar')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success"> Simpan </button>
                        <a href="{{ route('produk.index') }}"><button type="button" class="btn btn-danger"> Kembali </button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- template end -->
@endsection
