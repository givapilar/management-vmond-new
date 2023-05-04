<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\DaftarStokController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\BiliardController;
use App\Http\Controllers\MeetingRoomController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\DashboardController;




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

Route::get('/', function () {
    return view('auth.login');
});

// Route::post('/login', 'Auth\LoginController@login')->name('login');

// Route::post('/login', [LoginController::class, 'login'])->name('login');


    Auth::routes();

    Route::middleware('auth:web')->group(function () {

        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/dahboardd', [DashboardController::class, 'index'])->name('dashboard');
            // Master-data
            Route::get('/master-data', function () {
                return view('master-data.index');
            })->name('master-data.index');
    
            // tes
            Route::get('/tes', function () {
                return view('layouts.tes');
            })->name('tes.index');
    
            // User 
            Route::resource('/users', UserController::class);
    
            // departement
            Route::resource('/departement', DepartementController::class);
    
            // Material
            Route::resource('/material', MaterialController::class);


            // Material Import
            Route::post('/import-excel', [ImportExcelController::class, 'import'])->name('import-excel');

            // Inventory
            Route::get('/daftar-stok', [DaftarStokController::class, 'index'])->name('inventory.daftar-stok.index');
    
    
            // inventory Stok masuk
            Route::resource('/stok-masuk', StokMasukController::class);
    
            // inventory Stok Keluar
            Route::resource('/stok-keluar', StokKeluarController::class);
    
            // Management Toko Online
            Route::get('/management-toko-online', function () {
                return view('management-toko-online.index');
            })->name('management-toko-online.index');
    
            // Management Restaurant
            Route::resource('/restaurant', RestaurantController::class);
    
            // Management Biliard
            Route::resource('/biliard', BiliardController::class);
    
            // Management Meeting Room
            Route::resource('/meeting-room', MeetingRoomController::class);
    });