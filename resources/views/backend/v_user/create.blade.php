@extends('backend.v_layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card-deck">
        <div class="card shadow mb-4">
            <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <div class="card-header">
                    <strong class="card-title">Tambah User</strong>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Hak Akses</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="" {{ old('role') == '' ? 'selected' : '' }}> - Pilih Hak Akses - </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                            @error('role')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama User">
                            @error('nama')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email User">
                            @error('email')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress">HP</label>
                            <input type="text" onkeypress="return hanyaAngka(event)" name="hp" value="{{ old('hp') }}" class="form-control @error('hp') is-invalid @enderror" placeholder="Masukkan Nomor HP">
                            @error('hp')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputAddress">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password">
                            @error('password')
                            <span class="invalid-feedback alert-danger" role="alert">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{route('user.index')}}"><button type="button" class="btn btn-danger">Kembali</button></a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
