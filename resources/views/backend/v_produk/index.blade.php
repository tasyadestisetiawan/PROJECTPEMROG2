@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row justify-content-center">
    <div class="col-12">
        <a href="{{ route('produk.create') }}" title="Tambah Data">
            <button type="button" class="btn mb-2 btn-outline-info">Tambah</button>
        </a>
        <!-- table -->
        <table class="table datatables" id="dataTable-1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th>Berat</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            @foreach ($produk as $index =>$row)
            <tbody>
                <td>{{$index+1}}</td>
                <td>{{ $row->kategori->nama_kategori }}</td>
                <td>{{$row->nama_produk}}</td>
                <td>{{$row->berat}}</td>
                <td>{{$row->satuan}}</td>
                <td>{{$row->harga}}</td>
                <td>{{$row->stok}}</td>
                <td>
                    <a href="{{ route('produk.edit', $row->id) }}" title="Ubah Data">
                        <span class="btn btn-success btn-sm show_confirm"><i class="fa fa-edit"></i>Ubah</span>
                    </a>
                    <form method="POST" action="{{ route('produk.destroy', $row->id) }}" style="display: inline-block;">
                        @method('delete')
                        @csrf
                        <button type="button" class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' data-konf-delete="{{ $row->nama_produk }}"><i class="fa fa-trash"></i>Hapus</button></button>
                    </form>
                </td>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection