<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Customer;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = Transaksi::with('produk', 'customer')->orderBy('id', 'desc')->get();
        return view('backend.v_transaksi.index', [
            'judul' => 'transaksi',
            'sub' => 'Data transaksi',
            'transaksi' => $transaksi
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::orderBy('id', 'asc')->get();
        $customer = Customer::orderBy('nama_customer', 'asc')->get(); // Ambil data customer
        return view('backend.v_transaksi.create', [
            'judul' => 'Transaksi',
            'sub' => 'Tambah Transaksi',
            'produk' => $produk,
            'customer' => $customer // Kirim data customer ke view
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'customer_id' => 'required',
        'produk_id' => 'required',
        'quantity' => 'required|integer|min:1',
        'tanggal' => 'required|date',
    ]);

    // Ambil produk berdasarkan ID
    $produk = Produk::findOrFail($request->produk_id);

    // Hitung total harga (harga satuan * quantity)
    $total_harga = $produk->harga * $request->quantity;

    // Simpan data ke database
    Transaksi::create([
        'customer_id' => $validatedData['customer_id'],
        'produk_id' => $validatedData['produk_id'],
        'quantity' => $validatedData['quantity'],
        'berat' => $produk->berat, // Ambil berat dari produk
        'harga_satuan' => $produk->harga,
        'subtotal_harga' => $produk->harga * $request->quantity, // Jika subtotal harga juga diambil dari produk
        'total_harga' => $total_harga,
        'tanggal' => $validatedData['tanggal'],
    ]);

    return redirect('/transaksi')->with('success', 'Data berhasil tersimpan');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::orderBy('nama_produk', 'asc')->get();
        $transaksi = Transaksi::findOrFail($id);
        return view('backend.v_transaksi.edit', [
            'judul' => 'Transaksi',
            'sub' => 'Ubah Transaksi',
            'produk' => $produk,
            'edit' => $transaksi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $validatedData = $request->validate([
            'nama_customer' => 'required',
            'produk_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'berat' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);

        // Ambil produk berdasarkan ID
        $produk = Produk::findOrFail($request->produk_id);

        // Hitung subtotal harga (harga satuan * quantity)
        $subtotal_harga = $produk->harga * $request->quantity;

        // Hitung total harga (subtotal * berat)
        $total_harga = $subtotal_harga * $request->berat;

        // Update data transaksi
        $transaksi->nama_customer = $validatedData['nama_customer'];
        $transaksi->produk_id = $validatedData['produk_id'];
        $transaksi->quantity = $validatedData['quantity'];
        $transaksi->berat = $validatedData['berat'];
        $transaksi->subtotal_harga = $subtotal_harga;
        $transaksi->total_harga = $total_harga; // Pastikan 'total_harga' diupdate dengan nilai yang benar
        $transaksi->tanggal = $validatedData['tanggal'];
        $transaksi->save();

        return redirect('/transaksi')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect('/transaksi');
    }
}
