@extends('layouts.master')

@section('title', 'Dashboard Superadmin')

@section('content')

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <h3 class="font-weight-bold mb-1">Dashboard</h3>
            <p class="text-muted small">Monitoring sistem & perusahaan</p>
        </div>
    </div>

    {{-- SUMMARY CARD --}}
    <div class="row">

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total Admin</h6>
                    <h2 class="font-weight-bold">{{ $totalAdmin }}</h2>
                    <small>User role admin</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Total Perusahaan</h6>
                    <h2 class="font-weight-bold">{{ $totalOwner }}</h2>
                    <small>Owner terdaftar</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>User Owner</h6>
                    <h2 class="font-weight-bold">{{ $totalUserOwner }}</h2>
                    <small>Role owner</small>
                </div>
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="row">
        <div class="col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Jumlah Perusahaan</h4>
                    <canvas id="companyChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('companyChart').getContext('2d');

        const labels = @json($chartLabels);
        const data = @json($chartData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.map(b => {
                    const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                        'Nov', 'Des'
                    ];
                    return bulan[b - 1];
                }),
                datasets: [{
                    label: 'Jumlah Perusahaan',
                    data: data,
                    borderColor: '#4b49ac',
                    backgroundColor: 'rgba(75, 73, 172, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
