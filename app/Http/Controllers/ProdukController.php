<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::orderBy('id', 'desc')->get();
        return view('backend.v_produk.index', [
            'judul' => 'Produk',
            'sub' => 'Data Produk',
            'produk' => $produk
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $kategori = Kategori::orderBy('id', 'asc')->get();
        return view('backend.v_produk.create', [
            'judul' => 'Produk',
            'sub' => 'Tambah Produk',
            'kategori' => $kategori
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ddd($request);
        $validatedData = $request->validate([
            'nama_produk' => 'required|max:255|unique:produk',
            'kategori_id' => 'required',
            'berat' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ]);
        Produk::create($validatedData);
        return redirect('/produk')->with('success', 'Data berhasil tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        $produk = Produk::findOrFail($id);
        return view('backend.v_produk.edit', [
            'judul' => 'Produk',
            'sub' => 'Ubah Produk',
            'kategori' => $kategori,
            'edit' => $produk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);
        $rules = [
            'nama_produk' => 'required',
            'kategori_id' => 'required',
            'berat' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'stok' => 'required',
        ];

        if ($request->judul != $produk->judul) {
            $rules['judul'] = 'required|max:255|unique:produk';
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect('/produk');
    }
}
