@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row justify-content-center">
    <div class="col-12">
        <a href="{{ route('kategori.create') }}" title="Tambah Data">
            <button type="button" class="btn mb-2 btn-outline-info">Tambah</button>
        </a>
        <div class="card-body">
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <!-- table -->
            <table class="table datatables" id="dataTable-1">
                <thead>
                    <tr>
                        <th>
                            <h6>No</h6>
                        </th>
                        <th>
                            <h6>Nama Kategori</h6>
                        </th>
                        <th>
                            <h6>Nama Admin</h6>
                        </th>
                        <th>
                            <h6>Aksi</h6>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($kategori as $index =>$row)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$row->nama_kategori}}</td>
                        <td>{{ $row->user ? $row->user->nama : '' }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $row->id) }}" class="btn btn-primary btn-sm">Edit</a>

                            <form action="{{ route('kategori.destroy', $row->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endsection