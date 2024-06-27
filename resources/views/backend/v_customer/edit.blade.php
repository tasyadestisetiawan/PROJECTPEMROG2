@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('customer.update', $edit->id) }}" method="post" class="form-horizontal">
                @method('put')
                @csrf

                <div class="card-body">
                    <h4 class="card-title">{{ $sub }}</h4>

                    <div class="form-row">
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
                            <label for="inputPassword4">Email</label>
                            <input type="text" name="email" value="{{ old('email',$edit->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Nomor Email">
                            @error('email')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputPassword4">HP</label>
                            <input type="text" name="hp" value="{{ old('hp',$edit->hp) }}" class="form-control @error('hp') is-invalid @enderror" placeholder="Masukkan Nomor HP">
                            @error('hp')
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
                        <a href="{{ route('customer.index') }}">
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