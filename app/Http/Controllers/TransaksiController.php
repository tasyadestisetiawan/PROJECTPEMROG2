<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Customer;
use Dompdf\Dompdf;
use Dompdf\Options;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('produk', 'customer', 'user')->orderBy('id', 'desc')->get();
        return view('backend.v_transaksi.index', [
            'judul' => 'transaksi',
            'sub' => 'Data transaksi',
            'transaksi' => $transaksi
        ]);
    }

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
            Log::error('Stok produk tidak mencukupi.', ['produk_id' => $request->produk_id, 'quantity' => $validatedData['quantity']]);
            return redirect()->back()->withErrors(['stok' => 'Stok produk tidak mencukupi.']);
        }

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'customer_id' => $validatedData['customer_id'],
                'produk_id' => $validatedData['produk_id'],
                'quantity' => $validatedData['quantity'],
                'berat' => $produk->berat,
                'harga_satuan' => $produk->harga,
                'total_harga' => $produk->harga * $validatedData['quantity'],
                'tanggal' => $validatedData['tanggal'],
                'user_id' => Auth::id(),
            ]);

            // Kurangi stok produk
            $produk->stok -= $validatedData['quantity'];
            $produk->save();

            DB::commit();
            return redirect('/transaksi')->with('success', 'Data berhasil tersimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Terjadi kesalahan saat menyimpan data.', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

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
        $oldQuantity = $transaksi->quantity;
        $newQuantity = $validatedData['quantity'];
        $total_harga = $produk->harga * $newQuantity;

        DB::beginTransaction();
        try {
            // Update stok produk berdasarkan selisih quantity lama dan baru
            $difference = $newQuantity - $oldQuantity;
            $produk->stok -= $difference;

            if ($produk->stok < 0) {
                DB::rollBack();
                return redirect()->back()->withErrors(['quantity' => 'Stok produk tidak mencukupi']);
            }

            $produk->save();

            $transaksi->update([
                'customer_id' => $validatedData['customer_id'],
                'produk_id' => $validatedData['produk_id'],
                'quantity' => $newQuantity,
                'berat' => $produk->berat,
                'harga_satuan' => $produk->harga,
                'total_harga' => $total_harga,
                'tanggal' => $validatedData['tanggal'],
            ]);

            DB::commit();
            return redirect('/transaksi')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Terjadi kesalahan saat menyimpan data.', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Periksa apakah transaksi sudah dibayar
        if ($transaksi->pembayaran) {
            return redirect()->back()->withErrors(['error' => 'Transaksi sudah dibayar dan tidak dapat dihapus.']);
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok produk saat transaksi dihapus
            $produk = Produk::findOrFail($transaksi->produk_id);
            $produk->stok += $transaksi->quantity;
            $produk->save();

            $transaksi->delete();

            DB::commit();
            return redirect('/transaksi')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Terjadi kesalahan saat menghapus data.', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }

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

        // Simpan pdf ke penyimpanan
        file_put_contents($filePath . $fileName, $output);

        // Respon download
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
