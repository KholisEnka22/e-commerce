<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('admin', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::group([

    'middleware' => 'api',

], function () {

    Route::resources([
        'kategori' => KategoriController::class,
        'subkategori' => SubKategoriController::class,
        'slider' => SliderController::class,
        'produk' => ProdukController::class,
        'member' => MemberController::class,
        'testimoni' => TestimoniController::class,
        'review' => ReviewController::class,
        'order' => OrderController::class,
    ]);

    Route::get('order/dikonfirmasi', [OrderController::class, 'dikonfirmasi']);
    Route::get('order/dikemas', [OrderController::class, 'dikemas']);
    Route::get('order/dikirm', [OrderController::class, 'dikonfirmasi']);
    Route::get('order/diterima', [OrderController::class, 'dikonfirmasi']);
    Route::get('order/selesai', [OrderController::class, 'selesai']);
    Route::get('order/ubah_status/{order}', [OrderController::class, 'ubah_status']);

    Route::get('report', [ReportController::class, 'index']);
});