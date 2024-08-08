<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('user')->orderBy('id', 'desc')->get();
        return view('backend.v_produk.index', [
            'judul' => 'Produk',
            'sub' => 'Data Produk',
            'produk' => $produk
        ]);
    }

    public function create()
    {
        $kategori = Kategori::orderBy('id', 'asc')->get();
        return view('backend.v_produk.create', [
            'judul' => 'Produk',
            'sub' => 'Tambah Produk',
            'kategori' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required',
            'kategori_id' => 'required',
            'berat' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->file('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->storeAs('public/produk', $imageName);
            $validatedData['gambar'] = 'produk/' . $imageName;
        }
        $validatedData['user_id'] = Auth::id();
        Produk::create($validatedData);

        return redirect('/produk')->with('success', 'Produk berhasil disimpan');
    }

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
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->judul != $produk->judul) {
            $rules['judul'] = 'required|max:255|unique:produk';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('gambar')) {
            if ($produk->gambar) {
                Storage::delete('public/' . $produk->gambar);
            }
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->storeAs('public/produk', $imageName);
            $validatedData['gambar'] = 'produk/' . $imageName;
        }

        $produk->update($validatedData);
        return redirect('/produk')->with('success', 'Produk berhasil diupdate');
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('backend.v_produk.show', compact('produk'));
    }

    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->transaksi()->exists()) {
            return redirect('/produk')->with('error', 'Produk tidak dapat dihapus karena sudah terkait dengan transaksi.');
        }
        if ($produk->gambar) {
            Storage::delete('public/' . $produk->gambar);
        }
        $produk->delete();
        return redirect('/produk')->with('success', 'Produk berhasil dihapus');
    }
}
