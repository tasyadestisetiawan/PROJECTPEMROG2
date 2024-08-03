<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


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
        $sub = 'Tambah Transaksi';
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
                'total_harga' => $produk->harga * $validatedData['quantity'],
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
        $customers = Customer::orderBy('nama_customer', 'asc')->get();

        return view('backend.v_transaksi.edit', [
            'judul' => 'Transaksi',
            'sub' => 'Ubah Transaksi',
            'produk' => $produk,
            'edit' => $transaksi,
            'customers' => $customers,
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
        $total_harga = $subtotal_harga;

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
                // Ambil bulan dan tahun dari request month
                $month = date('m', strtotime($request->month));
                $year = date('Y', strtotime($request->month));
                return $query->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
            })
            ->when($request->year, function ($query) use ($request) {
                return $query->whereYear('tanggal', $request->year);
            })
            ->orderByDesc('tanggal')
            ->get();

        $data = [
            'transaksi' => $transaksi,
            'filter' => [
                'date' => $request->date,
                'month' => $request->month,
                'year' => $request->year,
            ],
        ];

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml(view('backend.transaksi.pdf', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $output = $dompdf->output();
        $filePath = public_path('exports/');
        $fileName = 'laporan_transaksi_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        // Save the PDF to storage
        file_put_contents($filePath . $fileName, $output);

        // Return a response with a download link
        return Response::download($filePath . $fileName, $fileName);
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
