<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Carimobilku\BerandaController;
use App\Http\Controllers\Carimobilku\BlogController;
use App\Http\Controllers\Carimobilku\GarasiController;
use App\Http\Controllers\Carimobilku\HubungiController;
use App\Http\Controllers\Carimobilku\PromoController;
use App\Http\Controllers\Mazda\MazdaBeranda;
use App\Http\Controllers\Mazda\MazdaBerita;
use App\Http\Controllers\Mazda\MazdaProduk;
use Illuminate\Support\Facades\Route;

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

Route::post('auth', [AuthController::class, 'index']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('auth/validate', [AuthController::class, 'validateToken']);
    
    Route::get('beranda', [BerandaController::class, 'index']);
    
    Route::get('garasi', [GarasiController::class, 'index']);
    Route::get('garasi/{slug}', [GarasiController::class, 'detail']);

    Route::get('blog', [BlogController::class, 'index']);
    Route::get('blog/{slug}', [BlogController::class, 'detail']);

    Route::get('promo', [PromoController::class, 'index']);
    Route::get('promo/{slug}', [PromoController::class, 'detail']);

    Route::post('hubungi', [HubungiController::class, 'index']);

    /* Mazda */
    Route::get('home',[MazdaBeranda::class, 'index']);
    Route::get('produk/{id}',[MazdaProduk::class, 'detail']);

    Route::get('berita',[MazdaBerita::class,'index']);
    Route::get('berita/{slug}',[MazdaBerita::class,'detail']);

});
