<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'superadmin' => view('dashboard.dashboard_superadmin'),
            'admin'      => view('dashboard.dashboard_admin'),
            'owner'      => view('dashboard.dashboard_owner'),
            'kasir'      => view('dashboard.dashboard_kasir'),
            default      => abort(403),
        };
    }
}
