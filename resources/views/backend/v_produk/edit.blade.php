@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('produk.update', $edit->id) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                @method('put')
                @csrf

                <div class="card-body">
                    <h4 class="card-title">{{ $sub }}</h4>

                    <div class="form-row">
                        <!-- Existing fields -->
                        <div class="form-group col-md-12">
                            <label>Kategori</label><br>
                            <select class="form-control @error('kategori_id') is-invalid @enderror" name="kategori_id">
                                <option value="" selected>--Pilih Tempat--</option>
                                @foreach ($kategori as $row)
                                <option value="{{ $row->id }}" {{ $edit->kategori_id == $row->id ? 'selected' : '' }}>{{ $row->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <p></p>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Nama produk</label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk',$edit->nama_produk) }}" class="form-control @error('nama_produk') is-invalid @enderror" placeholder="Masukkan nama produk">
                            @error('nama_produk')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Berat</label>
                            <input type="text" name="berat" value="{{ old('berat',$edit->berat) }}" class="form-control @error('berat') is-invalid @enderror" placeholder="Masukkan Berat">
                            @error('berat')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Satuan</label>
                            <input type="text" name="satuan" value="{{ old('satuan',$edit->satuan) }}" class="form-control @error('satuan') is-invalid @enderror" placeholder="Masukkan Satuan">
                            @error('satuan')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Harga</label>
                            <input type="text" name="harga" value="{{ old('harga',$edit->harga) }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan Harga">
                            @error('harga')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Stok</label>
                            <input type="text" name="stok" value="{{ old('stok',$edit->stok) }}" class="form-control @error('stok') is-invalid @enderror" placeholder="Masukkan Stok">
                            @error('stok')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- New field for image upload -->
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Gambar</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
                            @error('gambar')
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
                        <a href="{{ route('produk.index') }}">
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
