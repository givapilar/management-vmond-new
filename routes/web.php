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
use App\Http\Controllers\BannerController;




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

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Route::post('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        // Route::get('/dahboardd', [DashboardController::class, 'index'])->name('dashboard');
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
            Route::get('/profile', [UserController::class, 'profile'])->name('profile');

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

            // Management Banner
            Route::resource('/banner', BannerController::class);
    });

    Route::prefix('kitchen')->name('kitchen.')->group(function () {
        Route::get('/dashboard', function(){
            $data['page_title'] = 'dashboard';
            return view('process.kitchen.dashboard', $data);
        })->name('dashboard');
    });

    Route::prefix('bartender')->name('bartender.')->group(function () {
        Route::get('/dashboard', function(){
            $data['page_title'] = 'dashboard';
            return view('process.bartender.dashboard', $data);
        })->name('dashboard');
    });

    Route::prefix('waiters')->name('waiters.')->group(function () {
        Route::get('/dashboard', function(){
            $data['page_title'] = 'dashboard';
            return view('process.waiters.dashboard', $data);
        })->name('dashboard');
    });
