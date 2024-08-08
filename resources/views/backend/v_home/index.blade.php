@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <h3><center>Selamat Datang {{ $user->nama }} di Sistem Penjualan Toko Emas HIDUP BSI TEGAL</center></h3>   
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Data Customer</h5>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($customers as $customer)
                        <li>{{ $customer->nama_customer }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <p>Total Transaksi: {{ $totalTransaksi }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!--  Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <canvas id="myChart" width="400" height="50"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($bulan) !!},
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: {!! json_encode($jumlah_transaksi) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
@endsection