<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'superadmin' => $this->superadminDashboard(),
            'admin'      => $this->AdminDashboard(),
            'owner'      => view('dashboard.dashboard_owner'),
            'kasir'      => view('dashboard.dashboard_kasir'),
            default      => abort(403),
        };
    }

    private function superadminDashboard()
    {
        return view('dashboard.dashboard_superadmin', [
            'totalAdmin'  => User::where('role', 'admin')->count(),
            'totalOwner'  => Owner::count(),
            'totalUserOwner' => User::where('role', 'owner')->count(),

            // chart data
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

    private function AdminDashboard()
    {
        return view('dashboard.dashboard_admin', [
            'totalAdmin'  => User::where('role', 'admin')->count(),
            'totalOwner'  => Owner::count(),
            'totalUserOwner' => User::where('role', 'owner')->count(),

            // chart data
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
}
