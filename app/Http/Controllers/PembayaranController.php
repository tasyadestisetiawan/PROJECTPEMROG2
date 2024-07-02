<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Transaksi; // Tambahkan ini untuk mengimpor model Transaksi

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::with('transaksi.customer')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('backend.v_pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat pembayaran baru
        return view('backend.v_pembayaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form pembayaran
        $request->validate([
            'transaksi_id' => 'required',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        // Cari transaksi berdasarkan ID yang dikirim dari form
        $transaksi = Transaksi::findOrFail($request->transaksi_id);

        // Hitung kembalian berdasarkan jumlah bayar dan total harga transaksi
        $kembalian = $request->jumlah_bayar - $transaksi->total_harga;

        // Simpan pembayaran ke dalam tabel pembayaran
        $pembayaran = Pembayaran::create([
            'transaksi_id' => $request->transaksi_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'kembalian' => $kembalian >= 0 ? $kembalian : null,
        ]);

        // Redirect ke halaman detail transaksi setelah pembayaran disimpan
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
        // Validasi input dari form update pembayaran
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        // Cari transaksi berdasarkan ID yang terkait dengan pembayaran
        $transaksi = Transaksi::findOrFail($pembayaran->transaksi_id);

        // Hitung kembali kembalian berdasarkan jumlah bayar yang baru dan total harga transaksi
        $kembalian = $request->jumlah_bayar - $transaksi->total_harga;

        // Update data pembayaran dengan data yang baru
        $pembayaran->update([
            'jumlah_bayar' => $request->jumlah_bayar,
            'kembalian' => $kembalian >= 0 ? $kembalian : null,
        ]);

        // Redirect ke halaman detail transaksi setelah pembayaran diupdate
        return redirect()->route('transaksi.show', $pembayaran->transaksi_id)
                         ->with('success', 'Pembayaran berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        // Simpan ID transaksi yang terkait dengan pembayaran
        $transaksi_id = $pembayaran->transaksi_id;

        // Hapus pembayaran dari tabel pembayaran
        $pembayaran->delete();

        // Redirect ke halaman detail transaksi setelah pembayaran dihapus
        return redirect()->route('transaksi.show', $transaksi_id)
                         ->with('success', 'Pembayaran berhasil dihapus');
    }
}
