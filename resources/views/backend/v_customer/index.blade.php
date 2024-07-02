@extends('backend.v_layouts.app')
@section('content')
<!-- template -->

<div class="row justify-content-center">
    <div class="col-12">
        <a href="{{ route('customer.create') }}" title="Tambah Data">
            <button type="button" class="btn mb-2 btn-outline-info">Tambah</button>
        </a>

        <!-- table -->
        <table class="table datatables" id="dataTable-1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>Email</th>
                    <th>HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            @foreach ($customer as $index =>$row)
            <tbody>
                <td>{{$index+1}}</td>
                <td>{{$row->nama_customer}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->hp}}</td>
                <td>
                <a href="{{ route('customer.edit', $row->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('customer.destroy', $row->id) }}" method="POST" style="display: inline-block;">
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