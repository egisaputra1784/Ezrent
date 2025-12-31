@extends('layouts.master')

@section('title', 'Manajemen Transaksi')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <h3 class="mb-0">Daftar Transaksi</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#transaksiModal">
                <i class="typcn typcn-plus mr-1"></i> Tambah Transaksi
            </button>
        </div>

        <div class="mb-3">
            <form method="GET">
                <input type="text" name="search" class="form-control" placeholder="Cari customer..."
                    value="{{ request('search') }}">
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Tanggal Sewa</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th>Jaminan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $tr)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tr->customer->nama }}</td>
                            <td>{{ $tr->produk->nama_produk }}</td>
                            <td>{{ number_format($tr->harga, 0, ',', '.') }}</td>
                            <td>{{ $tr->tanggal_sewa }}</td>
                            <td>{{ $tr->tanggal_kembali }}</td>
                            <td>Rp {{ number_format($tr->denda, 0, ',', '.') }}</td>
                            <td>{{ strtoupper($tr->status) }}</td>
                            <td>
                                @if ($tr->jaminan_tipe)
                                    {{ $tr->jaminan_tipe }}
                                    {{ $tr->jaminan_tipe == 'uang' ? 'Rp ' . number_format($tr->jaminan_nilai, 0, ',', '.') : $tr->jaminan_detail }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('transaksi.destroy', $tr->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="typcn typcn-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @includeIf('transaksi.modal')
@endsection


@push('scripts')
    <script>
        $('#jaminan_tipe').change(function() {
            const tipe = $(this).val();
            $('#jaminan_uang, #jaminan_identitas').hide();
            if (tipe == 'uang') $('#jaminan_uang').show();
            if (tipe == 'identitas') $('#jaminan_identitas').show();
        });
        // Toggle jaminan fields
        document.getElementById('jaminan_tipe').addEventListener('change', function() {
            document.getElementById('jaminan_uang').style.display = this.value === 'uang' ? 'block' : 'none';
            document.getElementById('jaminan_identitas').style.display = this.value === 'identitas' ? 'block' :
                'none';
        });

        function hitungTotal() {
            const produkId = $('[name=produk_id]').val();
            const tanggalSewa = $('[name=tanggal_sewa]').val();
            const tanggalKembali = $('[name=tanggal_kembali]').val();

            if (!produkId || !tanggalSewa || !tanggalKembali) return;

            const hargaProduk = $('[name=produk_id] option:selected').data('harga'); // nanti set data-harga di option
            const diff = (new Date(tanggalKembali) - new Date(tanggalSewa)) / (1000 * 60 * 60 * 24) + 1;
            const total = hargaProduk * diff;
            $('[name=harga]').val(total);
        }

        // trigger
        $('[name=produk_id], [name=tanggal_sewa], [name=tanggal_kembali]').change(hitungTotal);
    </script>
@endpush
