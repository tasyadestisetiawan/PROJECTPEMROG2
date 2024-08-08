@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group text-center">
                            <img src="{{ asset($user->foto ? 'storage/' . $user->foto : 'backend/avatars/face-1.jpg') }}" alt="..." class="avatar-img rounded-circle mb-3" width="150" height="150">
                        </div>
                        @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="form-group">
                            <label for="nama">Name</label>
                            <input type="text" class="form-control" id="nama" value="{{ $user->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" value="{{ ucfirst($user->role) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="hp">HP</label>
                            <input type="text" class="form-control" id="hp" value="{{ $user->hp }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="foto">Photo</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="{{route('home')}}"><button type="button" class="btn btn-danger">Kembali</button></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection