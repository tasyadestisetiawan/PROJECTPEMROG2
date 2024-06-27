@extends('backend.v_layouts.app')
@section('content')
<!-- template -->
<div class="col-md-12">
        <div class="card-deck">
                <div class="card shadow mb-4">
                        <form action="{{ route('akun.store') }}" method="post" class="form-horizontal">
                                @csrf
                                <div class="card-header">
                                        <strong class="card-title">Tambah Akun</strong>
                                </div>
                                <div class="card-body">
                                        <form class="form-row">
                                                <div class="form-group col-md-12">
                                                        <label for="inputEmail4">Kode Akun</label>
                                                        <input type="text" name="kode_akun" value="{{ old('kode_akun') }}" class="form-control @error('kode_akun') is-invalid @enderror" placeholder="Masukkan Kode Akun">
                                                        @error('kode_akun')
                                                        <span class="invalid-feedback alert-danger" role="alert">
                                                                {{$message}}
                                                        </span>
                                                        @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                        <label for="inputAddress">Nama Akun</label>
                                                        <input type="text" name="nama_akun" value="{{ old('nama_akun') }}" class="form-control @error('nama_akun') is-invalid @enderror" placeholder="Masukkan Nama Akun">
                                                        @error('nama_akun')
                                                        <span class="invalid-feedback alert-danger" role="alert">
                                                                {{$message}}
                                                        </span>
                                                        @enderror
                                                </div>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                <a href="{{route('akun.index')}}"><button type="button" class="btn btn-danger">Kembali</button>
                                                </a>
                                        </form>
                                </div>
                        </form>
                </div>
        </div>
</div>
<!-- template end -->
@endsection