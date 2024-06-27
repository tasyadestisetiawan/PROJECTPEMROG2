@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('kategori.update', $edit->id) }}" method="post" class="form-horizontal">
                @method('put')
                @csrf

                <div class="card-body">
                    <h4 class="card-title">{{ $sub }}</h4>

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Nama Kategori</label>
                            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="form-control @error('nama_kategori') is-invalid @enderror" placeholder="Masukkan Nama Kategori">
                            @error('nama_kategori')
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
                        <a href="{{ route('kategori.index') }}">
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