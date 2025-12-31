@extends('layouts.master')

@section('title', 'Manajemen Transaksi')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-0 font-weight-bold">Manajemen Transaksi</h3>
                <small class="text-muted">Kelola data penyewaan produk</small>
            </div>

            <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#transaksiModal">
                <i class="typcn typcn-plus mr-1"></i> Tambah Transaksi
            </button>
        </div>

        {{-- SEARCH --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body py-3">
                <form method="GET">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white">
                                <i class="typcn typcn-zoom"></i>
                            </span>
                        </div>
                        <input type="text" name="search" class="form-control border-left-0"
                            placeholder="Cari nama customer..." value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Sewa</th>
                                <th>Kembali</th>
                                <th>Denda</th>
                                <th>Status</th>
                                <th>Jaminan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($transaksis as $tr)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="font-weight-semibold">
                                        {{ $tr->customer->nama }}
                                    </td>

                                    <td>{{ $tr->produk->nama_produk }}</td>

                                    <td>
                                        Rp {{ number_format($tr->harga, 0, ',', '.') }}
                                    </td>

                                    <td>{{ $tr->tanggal_sewa }}</td>
                                    <td>{{ $tr->tanggal_kembali }}</td>

                                    <td class="text-danger">
                                        Rp {{ number_format($tr->denda, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <span
                                            class="badge
                                            {{ $tr->status == 'aktif' ? 'badge-primary' : ($tr->status == 'selesai' ? 'badge-success' : 'badge-danger') }}">
                                            {{ strtoupper($tr->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($tr->jaminan_tipe)
                                            <small class="text-muted">
                                                {{ ucfirst($tr->jaminan_tipe) }} :
                                                {{ $tr->jaminan_tipe === 'uang' ? 'Rp ' . number_format($tr->jaminan_nilai, 0, ',', '.') : $tr->jaminan_detail }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($tr->status !== 'selesai')
                                            <form action="{{ route('transaksi.selesai', $tr->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm btn-success"
                                                    onclick="return confirm('Selesaikan transaksi ini?')">
                                                    <i class="typcn typcn-tick"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('transaksi.destroy', $tr->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus transaksi ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="typcn typcn-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">
                                        <i class="typcn typcn-info-large-outline mr-1"></i>
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL --}}
    @includeIf('transaksi.modal')
@endsection


@push('scripts')
    <script>
        // toggle jaminan
        $('#jaminan_tipe').on('change', function() {
            const tipe = $(this).val();
            $('#jaminan_uang, #jaminan_identitas').hide();
            if (tipe === 'uang') $('#jaminan_uang').show();
            if (tipe === 'identitas') $('#jaminan_identitas').show();
        });

        // hitung total otomatis
        function hitungTotal() {
            const harga = $('[name=produk_id] option:selected').data('harga');
            const sewa = $('[name=tanggal_sewa]').val();
            const kembali = $('[name=tanggal_kembali]').val();

            if (!harga || !sewa || !kembali) return;

            const diff = (new Date(kembali) - new Date(sewa)) / (1000 * 60 * 60 * 24) + 1;
            $('[name=harga]').val(harga * diff);
        }

        $('[name=produk_id], [name=tanggal_sewa], [name=tanggal_kembali]').on('change', hitungTotal);
    </script>
@endpush
