@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row justify-content-center">
    <div class="col-12">
        <a href="{{ route('kategori.create') }}" title="Tambah Data">
            <button type="button" class="btn mb-2 btn-outline-info">Tambah</button>
        </a>
        <!-- table -->
        <table class="table datatables" id="dataTable-1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($kategori as $index =>$row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$row->nama_kategori}}</td>
                    <td>
                        <a href="{{ route('kategori.edit', $row->id) }}" title="Ubah Data">
                            <span class="btn btn-success btn-sm show_confirm"><i class="fa fa-edit"></i>Ubah</span>
                        </a>
                        <form method="POST" action="{{ route('kategori.destroy', $row->id) }}" style="display: inline-block;">
                            @method('delete')
                            @csrf
                            <button type="button" class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' data-konf-delete="{{ $row->nama_kategori }}"><i class="fa fa-trash"></i>Hapus</button></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection