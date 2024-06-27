@extends('backend.v_layouts.app')
@section('content')
<!-- template -->
<div class="col-md-12">
    <div class="card-deck">
        <div class="card shadow mb-4">
            <form action="{{ route('customer.store') }}" method="post" class="form-horizontal">
                @csrf
                <div class="card-header">
                    <strong class="card-title">Tambah Customer</strong>
                </div>
                <div class="card-body">
                    <form class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Nama Customer</label>
                            <input type="text" name="nama_customer" value="{{ old('nama_customer') }}" class="form-control @error('nama_customer') is-invalid @enderror" placeholder="Masukkan Nama Customer">
                            @error('nama_customer')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email Customer">
                            @error('email')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress">HP</label>
                            <input type="text" name="hp" value="{{ old('hp') }}" class="form-control @error('hp') is-invalid @enderror" placeholder="Masukkan Nomor HP">
                            @error('hp')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{route('customer.index')}}"><button type="button" class="btn btn-danger">Kembali</button>
                        </a>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- template end -->
@endsection