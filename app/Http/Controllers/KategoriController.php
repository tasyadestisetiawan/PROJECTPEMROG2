<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::with('user')->orderBy('id', 'desc')->get();
        return view('backend.v_kategori.index', [
            'judul' => 'Kategori',
            'sub' => 'Data Kategori',
            'kategori' => $kategori
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_kategori.create', [
            'judul' => 'Kategori',
            'sub' => 'Tambah Kategori'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ddd($request);
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:255|unique:kategori',
        ]);
        $validatedData['user_id'] = Auth::id();
        Kategori::create($validatedData);
        return redirect('/kategori')->with('success', 'Data Kategori berhasil tersimpan');
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
        $kategori = Kategori::findOrFail($id);
        return view('backend.v_kategori.edit', [
            'judul' => 'Kategori',
            'sub' => 'Ubah Kategori',
            'edit' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $rules = [
            'nama_kategori' => 'required|max:255',
        ];
        if ($request->nama_kategori != $kategori->nama_kategori) {
            $rules['nama_kategori'] = 'required|max:255|unique:kategori';
        }

        $validatedData = $request->validate($rules);
        Kategori::where('id', $id)->update($validatedData);
        return redirect('/kategori')->with('success', 'Data Kategori berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        if ($kategori->produk()->exists()) {
            return redirect('/kategori')->with('error', 'Kategori tidak dapat dihapus karena sudah terkait dengan produk.');
        }
        $kategori->delete();
        return redirect('/kategori')->with('success', 'Data Kategori berhasil dihapus');
    }
}
