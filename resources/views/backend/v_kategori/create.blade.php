@extends('backend.v_layouts.app')
@section('content')
<!-- template -->
<div class="col-md-12">
        <div class="card-deck">
                <div class="card shadow mb-4">
                        <form action="{{ route('kategori.store') }}" method="post" class="form-horizontal">
                                @csrf

                                <div class="card-header">
                                        <strong class="card-title"> {{$sub}} </strong>
                                </div>
                                <div class="card-body">
                                        <form class="form-row">
                                                <div class="form-group col-md-12">
                                                        <label for="inputAddress">Nama Kategori</label>
                                                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="form-control @error('nama_kategori') is-invalid @enderror" placeholder="Masukkan Nama Kategori">
                                                        @error('nama_kategori')
                                                        <span class="invalid-feedback alert-danger" role="alert">
                                                                {{$message}}
                                                        </span>
                                                        @enderror
                                                </div>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                <a href="{{route('kategori.index')}}"><button type="button" class="btn btn-danger">Kembali</button>
                                                </a>
                                        </form>
                                </div>
                        </form>
                </div>
        </div>
</div>

<!-- template end -->
@endsection