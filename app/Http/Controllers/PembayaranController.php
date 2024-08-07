<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('customer', 'produk','user')->orderBy('created_at', 'desc')->get();
        $pembayarans = Pembayaran::with('transaksi.customer', 'transaksi.produk')->orderBy('created_at', 'desc')->get();

        return view('backend.v_pembayaran.index', compact('transaksis', 'pembayarans'));
    }

    public function create()
    {
        $transaksis = Transaksi::all();
        return view('backend.v_pembayaran.create', compact('transaksis'));
    }

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
            'user_id'=> Auth::id(),
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil disimpan');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $transaksis = Transaksi::all();
        return view('backend.v_pembayaran.edit', compact('pembayaran', 'transaksis'));
    }

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

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diupdate');
    }
}
