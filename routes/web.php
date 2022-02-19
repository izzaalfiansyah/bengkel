<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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


Route::get('/admin', function () {
    return redirect(url('admin/dashboard.html'));
});

Route::get('/admin/{any}', function() {
    if (Session::has('id') && Session::has('level')) {
        return view('admin');
    } else {
        return redirect('/login.html');
    }
})->where('any', '(.*)');

Route::get('/login/{id}/{level}', function($id, $level) {
    Session::put('id', $id);
    Session::put('level', $level);

    return redirect('/admin');
});

Route::get('/logout', function() {
    Session::flush();
    return redirect(url('/'));
});

Route::get('/print/transaksi/{id}', [\App\Http\Controllers\PrintController::class, 'transaksi']);
Route::get('/print/service/{id}', [\App\Http\Controllers\PrintController::class, 'service']);
Route::get('/print/pelanggan', [\App\Http\Controllers\PrintController::class, 'pelanggan']);

Route::get('/excel/kas', [\App\Http\Controllers\ExcelController::class, 'kas']);
Route::get('/excel/produk', [\App\Http\Controllers\ExcelController::class, 'produk']);
Route::get('/excel/jasa', [\App\Http\Controllers\ExcelController::class, 'jasa']);

Route::get('/{any}', function () {
    return view('home');
})->where('any', '(.*)');