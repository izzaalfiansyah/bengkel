<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api as Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('/bengkel', Api\BengkelController::class);
Route::post('/user/login', [Api\UserController::class, 'login']);
Route::resource('/user', Api\UserController::class);
Route::resource('/teknisi', Api\TeknisiController::class);
Route::resource('/supplier', Api\SupplierController::class);
Route::resource('/pelanggan/kendaraan', Api\KendaraanPelangganController::class);
Route::resource('/pelanggan', Api\PelangganController::class);
Route::get('/transaksi/report', [Api\TransaksiController::class, 'report']);
Route::get('/transaksi/produk', [Api\TransaksiController::class, 'produk']);
Route::get('/transaksi/jasa', [Api\TransaksiController::class, 'jasa']);
Route::resource('/transaksi', Api\TransaksiController::class);
Route::get('/service/invoice', [Api\ViewServiceController::class, 'invoice']);
Route::get('/service/work-order', [Api\ViewServiceController::class, 'workOrder']);
Route::get('/service/estimasi', [Api\ViewServiceController::class, 'estimasi']);
Route::resource('/service', Api\ServiceController::class);
Route::resource('/produk', Api\ProdukController::class);
Route::resource('/jasa', Api\JasaController::class);
Route::get('/kas/report', [Api\KasController::class, 'report']);
Route::get('/kas/graphic', [Api\KasController::class, 'graphic']);
Route::resource('/kas', Api\KasController::class);
Route::post('/whatsapp/send', [Api\WhatsappController::class, 'send']);
Route::resource('/setting', Api\AppController::class);