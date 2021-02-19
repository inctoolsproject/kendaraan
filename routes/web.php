<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PenjualanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[LoginController::class,'index']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => 'check.session'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'kendaraan'], function () {
        Route::get('/', [KendaraanController::class,'index'])->name('kendaraan.index');
        Route::get('/datatables', [KendaraanController::class, 'datatables'])->name('kendaraan.datatables');
        Route::post('/store', [KendaraanController::class, 'store'])->name('kendaraan.store');
        Route::get('/edit/{id}', [KendaraanController::class, 'edit'])->name('kendaraan.edit');
        Route::post('/update', [KendaraanController::class, 'update'])->name('kendaraan.update');
        Route::get('/delete/{id}', [KendaraanController::class, 'delete'])->name('kendaraan.delete');
        Route::get('/get_kendaraan', [KendaraanController::class, 'get_kendaraan'])->name('kendaraan.get_kendaraan');
    });

    Route::group(['prefix' => 'penjualan'], function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/datatables', [PenjualanController::class, 'datatables'])->name('penjualan.datatables');
        Route::post('/store', [PenjualanController::class, 'store'])->name('penjualan.store');
        Route::get('/invoice/{id}', [PenjualanController::class, 'invoice'])->name('penjualan.invoice');
        Route::get('/send_invoice/{id}', [PenjualanController::class, 'send_invoice'])->name('penjualan.send_invoice');
        Route::get('/send_chat/{id}', [PenjualanController::class, 'send_chat'])->name('penjualan.send_chat');
    });
});
