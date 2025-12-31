<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserKasirController;
use App\Http\Controllers\UserOwnerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD (ONE GATE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('superadmin.dashboard');

        Route::resource('users', UserController::class);
    });

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');
        Route::resource('owner', OwnerController::class);
        Route::resource('user-owner', UserOwnerController::class);
    });

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('owner.dashboard');

        Route::get('/user-kasir/export', [UserKasirController::class, 'exportExcel'])
            ->name('user-kasir.export');

        Route::resource('user-kasir', UserKasirController::class)
            ->except(['show']);


        Route::get('/laporan/transaksi', [LaporanController::class, 'transaksi'])
            ->name('laporan.transaksi');

        Route::get('/laporan/transaksi/excel', [LaporanController::class, 'exportExcel'])
            ->name('laporan.transaksi.excel');

        Route::get('/laporan/transaksi/pdf', [LaporanController::class, 'exportPdf'])
            ->name('laporan.transaksi.pdf');
    });

/*
|--------------------------------------------------------------------------
| KASIR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:kasir'])
    ->prefix('kasir')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('kasir.dashboard');

        Route::resource('customer', CustomerController::class)
            ->except(['show']);;

        Route::resource('kategori', KategoriController::class);

        Route::resource('produk', ProdukController::class);

        Route::resource('transaksi', TransaksiController::class);

        Route::put('/transaksi/{id}/selesai', [TransaksiController::class, 'selesai'])
            ->name('transaksi.selesai');

        Route::get('customer/export', [CustomerController::class, 'export'])->name('customer.export');

    });
