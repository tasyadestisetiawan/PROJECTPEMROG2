@extends('backend.v_layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Detail Produk</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th><h6>Kategori</h6></th>
                        <td>{{ $produk->kategori->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <th><h6>Nama Produk</h6></th>
                        <td>{{ $produk->nama_produk }}</td>
                    </tr>
                    <tr>
                        <th><h6>Berat</h6></th>
                        <td>{{ $produk->berat }}</td>
                    </tr>
                    <tr>
                        <th><h6>Satuan</h6></th>
                        <td>{{ $produk->satuan }}</td>
                    </tr>
                    <tr>
                        <th><h6>Harga</h6></th>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th><h6>Stok</h6></th>
                        <td>{{ $produk->stok }}</td>
                    </tr>
                    <tr>
                        <th><h6>Nama Admin</h6></th>
                        <td>{{ $produk->user->nama }}</td>
                    </tr>
                    <tr>
                        <th><h6>Gambar</h6></th>
                        <td>
                            @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width: 150px; height: 150px;">
                            @else
                            Tidak ada gambar
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

@endsection
