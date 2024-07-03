@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row justify-content-center">
    <div class="col-12">
        <a href="{{ route('user.create') }}" title="Tambah Data">
            <button type="button" class="btn mb-2 btn-outline-info">Tambah</button>
        </a>

        <!-- table -->
        <table class="table datatables" id="dataTable-1">
            <thead>
                <tr>
                    <th><h6>No</h6></th>
                    <th><h6>Nama</h6></th>
                    <th><h6>Akses</h6></th>
                    <th><h6>Email</h6></th>
                    <th><h6>HP</h6></th>
                    <th><h6>Aksi</h6></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($index as $row)
                <tr>
                    <td> {{ $loop->iteration }}</td>

                    <td> {{ $row->nama }} </td>
                    <td>
                        @if ($row->is_admin == 1)
                        Super Admin
                        @else
                        Administrator
                        @endif
                    </td>
                    <td> {{ $row->email }} </td>
                    <td> {{ $row->hp }} </td>
                    <td>
                    <a href="{{ route('user.edit', $row->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('user.destroy', $row->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>

                    </td>
                    @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection