<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mengambil data customer, sesuai dengan model dan query
        $customers = Customer::orderBy('created_at', 'desc')->limit(5)->get();

        // Menghitung total jumlah transaksi
        $totalTransaksi = Transaksi::count();

        // Mengambil data transaksi per bulan untuk grafik
        $transactions = Transaksi::selectRaw('MONTH(tanggal) as bulan, COUNT(id) as total_transaksi')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $jumlah_transaksi = [];

        // Inisialisasi data jumlah transaksi untuk setiap bulan
        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = Carbon::create()->month($i)->format('M');
            $jumlah_transaksi[] = 0;
        }

        // Memasukkan data transaksi ke dalam array sesuai bulan
        foreach ($transactions as $transaction) {
            $index = intval($transaction->bulan) - 1;
            $jumlah_transaksi[$index] = $transaction->total_transaksi;
        }

        return view('backend.v_home.index', compact('user','customers', 'totalTransaksi', 'bulan', 'jumlah_transaksi'));
    }
}
