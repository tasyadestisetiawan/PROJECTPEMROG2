<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akun = Akun::orderBy('id', 'desc')->get();
        return view('backend.v_akun.index', [
            'judul' => 'Akun',
            'sub' => 'Data Akun',
            'akun' => $akun
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('backend.v_akun.create', [
            'judul' => 'Akun',
            'sub' => 'Tambah Akun'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ddd($request);
        $validatedData = $request->validate([
            'kode_akun' => 'required',
            'nama_akun' => 'required',
        ]);
        Akun::create($validatedData);
        return redirect('/akun')->with('success', 'Data berhasil tersimpan');
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
        $akun = Akun::findOrFail($id);
        return view('backend.v_akun.edit', [
            'judul' => 'Akun',
            'sub' => 'Ubah Akun',
            'edit' => $akun
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $akun = Akun::findOrFail($id);
        $rules = [
            'kode_akun' => 'required',
            'nama_akun' => 'required',
        ];

        if ($request->judul != $akun->judul) {
            $rules['judul'] = 'required|max:255|unique:akun';
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $akun = Akun::findOrFail($id);
        $akun->delete();
        return redirect('/backend/akun');
    }
}
