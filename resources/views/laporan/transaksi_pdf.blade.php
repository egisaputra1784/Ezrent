<h3>Laporan Transaksi</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Denda</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksis as $tr)
            <tr>
                <td>{{ $tr->tanggal_sewa }}</td>
                <td>{{ $tr->customer->nama }}</td>
                <td>{{ $tr->produk->nama_produk }}</td>
                <td>{{ number_format($tr->harga) }}</td>
                <td>{{ number_format($tr->denda) }}</td>
                <td>{{ number_format($tr->harga + $tr->denda) }}</td>
                <td>{{ strtoupper($tr->status) }}</td>
            </tr>
        @endforeach
    </tbody>

    <hr>

    <table width="50%" cellspacing="0" cellpadding="6">
        <tr>
            <td><strong>Total Transaksi</strong></td>
            <td>: {{ $totalTransaksi }}</td>
        </tr>
        <tr>
            <td><strong>Total Pendapatan (Sewa)</strong></td>
            <td>: Rp {{ number_format($totalSewaMurni) }}</td>
        </tr>
        <tr>
            <td><strong>Total Denda</strong></td>
            <td>: Rp {{ number_format($totalDenda) }}</td>
        </tr>
        <tr>
            <td><strong>Total Pendapatan Akhir</strong></td>
            <td>: <strong>Rp {{ number_format($totalPendapatan) }}</strong></td>
        </tr>
    </table>

</table>
