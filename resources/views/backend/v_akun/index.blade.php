@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row justify-content-center">
    <div class="col-12">
        <a href="{{ route('akun.create') }}" title="Tambah Data">
            <button type="button" class="btn mb-2 btn-outline-info">Tambah</button>
        </a>

        <!-- table -->
        <table class="table datatables" id="dataTable-1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th>Aksi</th>
                </tr>
                @foreach ($akun as $index =>$row)
            </thead>

            <tr>
                <td>{{$index+1}}</td>
                <td>{{$row->kode_akun}}</td>
                <td>{{$row->nama_akun}}</td>
                <td>
                    <a href="{{ route('akun.edit', $row->id) }}" title="Ubah Data">
                        <span class="btn btn-success btn-sm show_confirm"><i class="fa fa-edit"></i>Ubah</span>
                    </a>
                    <form method="POST" action="{{ route('akun.destroy', $row->id) }}" style="display: inline-block;">
                        @method('delete')
                        @csrf
                        <button type="button" class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' data-konf-delete="{{ $row->nama_akun }}"><i class="fa fa-trash"></i>Hapus</button></button>
                    </form>
                </td>
            </tr>
            @endforeach
    </div>
</div>
@endsection