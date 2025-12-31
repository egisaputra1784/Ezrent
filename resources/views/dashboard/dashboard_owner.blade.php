@extends('layouts.master')

@section('title', 'Dashboard Owner')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="font-weight-bold mb-1">Dashboard Owner</h3>
                <p class="text-muted mb-0">
                    Selamat datang kembali, <strong>{{ Auth::user()->nama }}</strong> 👋
                </p>
            </div>
            <div class="text-muted small">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        {{-- SUMMARY CARD --}}
        <div class="row mb-4">

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Transaksi Bulan Ini</small>
                            <h3 class="font-weight-bold mb-0">{{ $totalTransaksiBulanIni }}</h3>
                        </div>
                        <i class="typcn typcn-chart-line text-primary" style="font-size:2.5rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-left-success">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Customer</small>
                            <h3 class="font-weight-bold mb-0">{{ $totalCustomer }}</h3>
                        </div>
                        <i class="typcn typcn-group text-success" style="font-size:2.5rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-left-warning">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Kasir</small>
                            <h3 class="font-weight-bold mb-0">{{ $totalKasir }}</h3>
                        </div>
                        <i class="typcn typcn-user text-warning" style="font-size:2.5rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-left-danger">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Produk</small>
                            <h3 class="font-weight-bold mb-0">{{ $totalProduk }}</h3>
                        </div>
                        <i class="typcn typcn-box text-danger" style="font-size:2.5rem;"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- CHART --}}
        <div class="row">

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <h5 class="font-weight-bold mb-0">📈 Transaksi</h5>
                                <small class="text-muted">30 hari terakhir</small>
                            </div>
                        </div>
                        <canvas id="chartTransaksi" height="140"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <h5 class="font-weight-bold mb-0">💰 Pendapatan</h5>
                                <small class="text-muted">bulan berjalan</small>
                            </div>
                        </div>
                        <canvas id="chartPendapatan" height="140"></canvas>
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
