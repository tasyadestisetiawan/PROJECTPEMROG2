<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Transaksi;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::with('transaksi.customer') // Mengambil relasi transaksi dan customer
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('backend.v_pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan form untuk membuat pembayaran
        return view('backend.v_pembayaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        $transaksi = Transaksi::findOrFail($request->transaksi_id);

        $kembalian = $request->jumlah_bayar - $transaksi->total_harga;

        $pembayaran = Pembayaran::create([
            'transaksi_id' => $request->transaksi_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'kembalian' => $kembalian >= 0 ? $kembalian : null,
        ]);

        return redirect()->route('transaksi.show', $request->transaksi_id)
                         ->with('success', 'Pembayaran berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        // Tampilkan form untuk mengedit pembayaran
        return view('backend.v_pembayaran.edit', compact('pembayaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        $transaksi = Transaksi::findOrFail($pembayaran->transaksi_id);

        $kembalian = $request->jumlah_bayar - $transaksi->total_harga;

        $pembayaran->update([
            'jumlah_bayar' => $request->jumlah_bayar,
            'kembalian' => $kembalian >= 0 ? $kembalian : null,
        ]);

        return redirect()->route('transaksi.show', $pembayaran->transaksi_id)
                         ->with('success', 'Pembayaran berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $transaksi_id = $pembayaran->transaksi_id;
        $pembayaran->delete();

        return redirect()->route('transaksi.show', $transaksi_id)
                         ->with('success', 'Pembayaran berhasil dihapus');
    }
}
