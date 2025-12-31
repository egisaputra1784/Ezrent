@extends('layouts.master')

@section('title', 'Laporan Transaksi')

@section('content')
    <div class="container-fluid">

        {{-- FILTER --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" class="row align-items-end">
                    <div class="col-md-3">
                        <label class="text-muted small">Dari Tanggal</label>
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small">Sampai Tanggal</label>
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-block">
                            <i class="typcn typcn-filter"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-left-primary shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Transaksi</small>
                        <h4 class="mb-0">{{ $totalTransaksi }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-success shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Sewa</small>
                        <h4 class="mb-0 text-success">
                            Rp {{ number_format($totalSewaMurni, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-warning shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Denda</small>
                        <h4 class="mb-0 text-warning">
                            Rp {{ number_format($totalDenda, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-dark shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Pendapatan</small>
                        <h4 class="mb-0">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">Data Transaksi</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $tr)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($tr->tanggal_sewa)->format('d M Y') }}</td>
                                <td>{{ $tr->customer->nama }}</td>
                                <td>{{ $tr->produk->nama_produk }}</td>
                                <td>
                                    Rp {{ number_format($tr->harga, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span
                                        class="badge
                                    {{ $tr->status == 'aktif' ? 'badge-primary' : ($tr->status == 'selesai' ? 'badge-success' : 'badge-danger') }}">
                                        {{ strtoupper($tr->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Tidak ada data transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
