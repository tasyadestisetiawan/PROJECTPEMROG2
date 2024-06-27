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
                    <th>No</th>
                    <th>Nama</th>
                    <th>Akses</th>
                    <th>Email</th>
                    <th>HP</th>
                    <th>Aksi</th>
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
                        <a href="{{ route('user.edit', $row->id) }}" title="Ubah Data">
                            <span class="btn btn-success btn-sm show_confirm"><i class="fa fa-edit"></i>Ubah</span>
                        </a>
                        <form method="POST" action="{{ route('user.destroy', $row->id) }}" style="display: inline-block;">
                            @method('delete')
                            @csrf
                            <button type="button" class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' data-konf-delete="{{ $row->nama }}"><i class="fa fa-trash"></i>Hapus</button></button>
                        </form>

                    </td>
                    @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection