@extends('layouts.master')

@section('title', 'Dashboard Owner')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="mb-4">
            <h3 class="font-weight-bold mb-1">Dashboard Owner</h3>
            <p class="text-muted mb-0">
                Selamat datang, {{ Auth::user()->nama }} 👋
            </p>
        </div>

        {{-- SUMMARY CARD --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Transaksi Bulan Ini</small>
                        <h3 class="font-weight-bold">{{ $totalTransaksiBulanIni }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Customer</small>
                        <h3 class="font-weight-bold">{{ $totalCustomer }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Kasir</small>
                        <h3 class="font-weight-bold">{{ $totalKasir }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Produk</small>
                        <h3 class="font-weight-bold">{{ $totalProduk }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHART --}}
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3 font-weight-bold">📈 Transaksi 30 Hari Terakhir</h5>
                        <canvas id="chartTransaksi" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3 font-weight-bold">💰 Pendapatan Bulan Ini</h5>
                        <canvas id="chartPendapatan" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const transaksiData = @json($transaksi30Hari);
        const pendapatanData = @json($pendapatanBulanIni);

        // ===== CHART TRANSAKSI =====
        new Chart(document.getElementById('chartTransaksi'), {
            type: 'line',
            data: {
                labels: transaksiData.map(item => item.tanggal),
                datasets: [{
                    label: 'Total Transaksi',
                    data: transaksiData.map(item => item.total),
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // ===== CHART PENDAPATAN =====
        new Chart(document.getElementById('chartPendapatan'), {
            type: 'bar',
            data: {
                labels: pendapatanData.map(item => item.tanggal),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: pendapatanData.map(item => item.total),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
