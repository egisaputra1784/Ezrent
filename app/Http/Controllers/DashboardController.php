<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Customer;
use App\Models\Produk;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'superadmin', 'admin' => $this->superadminDashboard(),
            'owner', 'kasir'      => $this->ownerDashboard(),
            default               => abort(403),
        };
    }

    private function superadminDashboard()
    {
        return view('dashboard.dashboard_superadmin', [
            'totalAdmin'      => User::where('role', 'admin')->count(),
            'totalOwner'      => Owner::count(),
            'totalUserOwner'  => User::where('role', 'owner')->count(),

            // chart owner per bulan
            'chartLabels' => Owner::selectRaw('MONTH(created_at) as bulan')
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->pluck('bulan'),

            'chartData' => Owner::selectRaw('COUNT(*) as total')
                ->groupByRaw('MONTH(created_at)')
                ->orderByRaw('MONTH(created_at)')
                ->pluck('total'),
        ]);
    }

    private function ownerDashboard()
    {
        $ownerId = Auth::user()->owner_id;

        // ===== SUMMARY =====
        $totalTransaksiBulanIni = Transaksi::where('owner_id', $ownerId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalCustomer = Customer::where('owner_id', $ownerId)->count();

        $totalKasir = User::where('owner_id', $ownerId)
            ->where('role', 'kasir')
            ->count();

        $totalProduk = Produk::where('owner_id', $ownerId)->count();

        // ===== CHART TRANSAKSI 30 HARI TERAKHIR =====
        $startDate = now()->subDays(29)->startOfDay();
        $endDate   = now()->startOfDay();

        $period = CarbonPeriod::create($startDate, $endDate);

        $rawTransaksi = Transaksi::where('owner_id', $ownerId)
            ->whereBetween('created_at', [$startDate, $endDate->endOfDay()])
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->pluck('total', 'tanggal');

        // 🔥 FIX DI SINI (Carbon $date)
        $transaksi30Hari = collect($period)->map(function (Carbon $date) use ($rawTransaksi) {
            $tanggal = $date->toDateString();

            return [
                'tanggal' => $tanggal,
                'total'   => (int) ($rawTransaksi[$tanggal] ?? 0),
            ];
        });

        // ===== CHART PENDAPATAN BULAN INI =====
        $daysInMonth = now()->daysInMonth;

        $bulanIni = collect(range(1, $daysInMonth))->map(function ($day) {
            return now()->startOfMonth()->addDays($day - 1)->toDateString();
        });

        $rawPendapatan = Transaksi::where('owner_id', $ownerId)
            ->where('status', 'selesai')
            ->whereMonth('tanggal_kembali', now()->month)
            ->whereYear('tanggal_kembali', now()->year)
            ->selectRaw('DATE(tanggal_kembali) as tanggal, SUM(harga + IFNULL(denda,0)) as total')
            ->groupByRaw('DATE(tanggal_kembali)')
            ->pluck('total', 'tanggal');


        $pendapatanBulanIni = $bulanIni->map(function ($tanggal) use ($rawPendapatan) {
            return [
                'tanggal' => $tanggal,
                'total'   => (int) ($rawPendapatan[$tanggal] ?? 0),
            ];
        });

        return view('dashboard.dashboard_owner', compact(
            'totalTransaksiBulanIni',
            'totalCustomer',
            'totalKasir',
            'totalProduk',
            'transaksi30Hari',
            'pendapatanBulanIni'
        ));
    }
}
