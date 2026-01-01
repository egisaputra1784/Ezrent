<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Carbon\Carbon;

class UpdateDenda extends Command
{
    // Nama command yang dipanggil di artisan
    protected $signature = 'update:denda';

    protected $description = 'Update denda transaksi yang terlambat setiap hari';

    public function handle()
    {
        $now = Carbon::now();

        // Ambil transaksi yang statusnya masih 'terlambat'
        $transaksis = Transaksi::with('produk')
            ->where('status', 'terlambat')
            ->get();

        foreach ($transaksis as $tr) {
            $tanggalKembali = Carbon::parse($tr->tanggal_kembali);

            if ($now->gt($tanggalKembali)) {
                $hariTerlambat = $tanggalKembali->diffInDays($now);

                $dendaPersenPerHari = $tr->produk->denda ?? 0;
                $totalDenda = $tr->harga * ($dendaPersenPerHari / 100) * $hariTerlambat;

                // update denda
                $tr->update([
                    'denda' => $totalDenda
                ]);

                $this->info("Transaksi #{$tr->id} denda updated: {$totalDenda}");
            }
        }

        $this->info('Update denda selesai ✅');
    }
}
