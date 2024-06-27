@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('user.update', $edit->id) }}" method="post" class="form-horizontal">
                @method('put')
                @csrf

                <div class="card-body">
                    <h4 class="card-title">{{ $sub }}</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Hak Ases</label>
                            <select name="is_admin" class="form-control @error('is_admin') is-invalid @enderror">
                                <option value="" {{ old('is_admin', $edit->is_admin) == '' ? 'selected' : '' }}> -
                                    Pilih Hak Akses -</option>
                                <option value="0" {{ old('is_admin', $edit->is_admin) == '0' ? 'selected' : '' }}>
                                    Admin</option>
                                <option value="1" {{ old('is_admin', $edit->is_admin) == '1' ? 'selected' : '' }}>
                                    Super Admin</option>
                            </select>
                            @error('is_admin')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputAddress">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama',$edit->nama) }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama User">
                            @error('nama')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Email</label>
                            <input type="text" name="email" value="{{ old('email',$edit->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email User">
                            @error('email')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress">HP</label>
                            <input type="text" onkeypress="return hanyaAngka(event)" name="hp" value="{{ old('hp',$edit->hp) }}" class="form-control @error('hp') is-invalid @enderror" placeholder="Masukkan Nomor HP">
                            @error('hp')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress">Password</label>
                            <input type="text" name="password" value="{{ old('password',$edit->password) }}" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Nomor Password">
                            @error('password')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
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
                        <a href="{{ route('user.index') }}">
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