<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Customer;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $sub = 'Tambah Transaksi'; // Pastikan variabel $sub terdefinisi dengan nilai 'Tambah Transaksi'
        return view('backend.v_transaksi.create', [
            'judul' => 'Transaksi',
            'sub' => $sub,
            'produk' => $produk,
            'customer' => $customer
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

        $produk = Produk::findOrFail($request->produk_id);

        // Cek stok produk sebelum membuat transaksi
        if ($produk->stok < $validatedData['quantity']) {
            return redirect()->back()->withErrors(['stok' => 'Stok produk tidak mencukupi.']);
        }

        // Gunakan transaksi database
        DB::beginTransaction();
        try {
            // Buat transaksi baru
            $transaksi = Transaksi::create([
                'customer_id' => $validatedData['customer_id'],
                'produk_id' => $validatedData['produk_id'],
                'quantity' => $validatedData['quantity'],
                'berat' => $produk->berat,
                'harga_satuan' => $produk->harga,
                'subtotal_harga' => $produk->harga * $validatedData['quantity'],
                'total_harga' => ($produk->harga * $validatedData['quantity']) * $produk->berat,
                'tanggal' => $validatedData['tanggal'],
            ]);

            // Kurangi stok produk
            $produk->stok -= $validatedData['quantity'];
            $produk->save();

            DB::commit();
            return redirect('/transaksi')->with('success', 'Data berhasil tersimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
   /**
 * Show the form for editing the specified resource.
 */
public function edit($id)
{
    $produk = Produk::orderBy('nama_produk', 'asc')->get();
    $transaksi = Transaksi::findOrFail($id);
    $customers = Customer::orderBy('nama_customer', 'asc')->get(); // Fetch customers
    
    return view('backend.v_transaksi.edit', [
        'judul' => 'Transaksi',
        'sub' => 'Ubah Transaksi',
        'produk' => $produk,
        'edit' => $transaksi,
        'customers' => $customers, // Pass customers to the view
    ]);
}

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'produk_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $subtotal_harga = $produk->harga * $request->quantity;
        $total_harga = $subtotal_harga * $produk->berat;

        $transaksi->update([
            'customer_id' => $validatedData['customer_id'],
            'produk_id' => $validatedData['produk_id'],
            'quantity' => $validatedData['quantity'],
            'berat' => $produk->berat,
            'harga_satuan' => $produk->harga,
            'subtotal_harga' => $subtotal_harga,
            'total_harga' => $total_harga,
            'tanggal' => $validatedData['tanggal'],
        ]);

        return redirect('/transaksi')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect('/transaksi')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Generate PDF for transactions based on filter.
     */
    /**
 * Generate PDF for transactions based on filter.
 */
public function generatePDF(Request $request)
{
    $request->validate([
        'date' => 'nullable|date',
        'month' => 'nullable|date_format:Y-m',
        'year' => 'nullable|integer|min:1970',
    ]);

    $transaksi = Transaksi::with('produk', 'customer')
                        ->when($request->date, function ($query) use ($request) {
                            return $query->whereDate('tanggal', $request->date);
                        })
                        ->when($request->month, function ($query) use ($request) {
                            return $query->whereMonth('tanggal', $request->month);
                        })
                        ->when($request->year, function ($query) use ($request) {
                            return $query->whereYear('tanggal', $request->year);
                        })
                        ->orderBy('tanggal', 'desc')
                        ->get();

    $data = [
        'transaksi' => $transaksi,
        'filter' => [
            'date' => $request->date,
            'month' => $request->month,
            'year' => $request->year,
        ],
    ];

    $pdf = PDF::loadView('backend.transaksi.pdf', $data);
    return $pdf->download('laporan_transaksi_' . now()->format('Y-m-d_H-i-s') . '.pdf');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('backend.v_transaksi.show', [
            'judul' => 'Detail Transaksi',
            'sub' => 'Detail Transaksi',
            'transaksi' => $transaksi,
        ]);
    }
}
