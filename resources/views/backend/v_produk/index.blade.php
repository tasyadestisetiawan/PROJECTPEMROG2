@extends('backend.v_layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <a href="{{ route('produk.create') }}" title="Tambah Data">
            <button type="button" class="btn mb-2 btn-outline-info">Tambah</button>
        </a>
        <div class="card-body">
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table datatables" id="dataTable-1">
                <thead>
                    <tr>
                        <th>
                            <h6>No</h6>
                        </th>
                        <th>
                            <h6>Kategori</h6>
                        </th>
                        <th>
                            <h6>Nama Produk</h6>
                        </th>
                        <th>
                            <h6>Berat</h6>
                        </th>
                        <th>
                            <h6>Harga</h6>
                        </th>
                        <th>
                            <h6>Stok</h6>
                        </th>
                        <th>
                            <h6>Gambar</h6>
                        </th>
                        <th>
                            <h6>Aksi</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->kategori->nama_kategori }}</td>
                        <td>{{ $row->nama_produk }}</td>
                        <td>{{ $row->berat }}</td>
                        <td>Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                        <td>{{ $row->stok }}</td>
                        <td>
                            @if($row->gambar)
                            <img src="{{ asset('storage/' . $row->gambar) }}" alt="{{ $row->nama_produk }}" style="width: 50px; height: 50px;">
                            @else
                            Tidak ada gambar
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('produk.show', $row->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('produk.edit', $row->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('produk.destroy', $row->id) }}" method="POST" style="display: inline-block;">
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
</div>

@endsection