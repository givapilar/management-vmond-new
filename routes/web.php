<?php

use App\Http\Controllers\AddOnBilliardController;
use App\Http\Controllers\AddOnController;
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
use App\Http\Controllers\AssetManagementsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\MejaRestaurantsController;
use App\Http\Controllers\HistoryLogsController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\DashboardKitchenController;
use App\Http\Controllers\MenuPackagesController;
use App\Http\Controllers\ReportPenjualanController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\DashboardBartenderController;
use App\Http\Controllers\DashboardWaiterController;
use App\Http\Controllers\DashboardServerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OtherSettingsController;
use App\Http\Controllers\ReportAnalyticController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TotalMemberController;

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

Route::get('/testpage', function () {
    return "testtt";
});

// Route::post('/login', 'Auth\LoginController@login')->name('login');

// Route::post('/login', [LoginController::class, 'login'])->name('login');


    Auth::routes();

    Route::middleware('auth:web')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/control-lamp', [DashboardController::class, 'dashboardControl'])->name('control-lamp');
        Route::post('/control-lamp/store/', [DashboardController::class, 'storeDashboardControl'])->name('control-lamp.store');
        Route::patch('/control-lamp/update/{id}', [DashboardController::class, 'updateDashboardControl'])->name('control-lamp.update');
        Route::delete('/control-lamp/{id}', [DashboardController::class, 'destroyDashboardControl'])->name('control-lamp.destroy');
        // Route::post('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        // Dashboard Analytic
        Route::get('/dashboard-analytic', [DashboardController::class, 'dashboardAnalytic'])->name('dashboard-analytic');

        // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        // Route::get('/dahboardd', [DashboardController::class, 'index'])->name('dashboard');
            // Master-data
            Route::get('/master-data', function () {
                return view('master-data.index');
            })->name('master-data.index');

            // // tes
            // Route::get('/tes', function () {
            //     return view('layouts.tes');
            // })->name('tes.index');

            // User
            Route::resource('/users', UserController::class);
            Route::get('/profile', [UserController::class, 'profile'])->name('profile');

            // Other Settings
            Route::get('/other-settings', [OtherSettingsController::class, 'index'])->name('other.index');
            Route::post('/other-settings/{id}', [OtherSettingsController::class, 'update'])->name('other.update');

            // departement
            Route::resource('/departement', DepartementController::class);

            // Material
            Route::resource('/bahan-baku', MaterialController::class);

            // Asset Management
            Route::resource('/asset-management', AssetManagementsController::class);

            // Asset Management Details
            // Route::resource('/asset-management-details', AssetManagementDetailController::class);

            // Tag
            Route::resource('/tag', TagsController::class);

            // Meja Restaurant
            Route::resource('/meja-restaurant', MejaRestaurantsController::class);
            Route::get('generate-barcode', [MejaRestaurantsController::class, 'qrDownload'])->name('meja-restaurant.qr');

            // Membership
            Route::resource('/membership', MembershipController::class);

            // Add On
            Route::resource('/add-on', AddOnController::class);

            // Add On
            Route::resource('/add-on-billiard', AddOnBilliardController::class);

            // Feedback
            Route::resource('/feedback', FeedbackController::class);

            // Material Import
            Route::post('/import-excel', [ImportExcelController::class, 'import'])->name('import-excel');


            // History Logs
            Route::resource('/history-log', HistoryLogsController::class);

            // Inventory
            Route::get('/daftar-stok', [DaftarStokController::class, 'index'])->name('inventory.daftar-stok.index');


            // inventory Stok masuk
            Route::resource('/stok-masuk', StokMasukController::class);

            // Permit
            Route::resource('/permit', PermitController::class);
            Route::get('permit/view', [PermitController::class, 'permit'])->name('permit.view');
            Route::get('permit/edit/{token}', [PermitController::class, 'editDataByPermit'])->name('editByPermit');
            Route::get('permit/delete/{token}', [PermitController::class, 'deleteViewDataByPermit'])->name('deleteByPermit');
            Route::post('permit/update/{token}', [PermitController::class, 'updateDataByPermit'])->name('updateByPermit');
            Route::delete('permit/delete/{token}', [PermitController::class, 'DeleteDataByPermit'])->name('actDeleteByPermit');

            // inventory Stok Keluar
            Route::resource('/stok-keluar', StokKeluarController::class);

            // Management Toko Online
            Route::get('/management-toko-online', function () {
                return view('management-toko-online.index');
            })->name('management-toko-online.index');

            // Management Restaurant
            Route::resource('/restaurant', RestaurantController::class);

            // Management Paket Menu
            Route::resource('/paket-menu', MenuPackagesController::class);

            // Management Supplier
            Route::resource('/supplier', SupplierController::class);

            // Management Biliard
            Route::resource('/biliard', BiliardController::class);

            // Management Meeting Room
            Route::resource('/meeting-room', MeetingRoomController::class);

            // Management Banner
            Route::resource('/media-advertising', BannerController::class);

            // Report Penjualan
            Route::resource('/report-penjualan', ReportPenjualanController::class);

            // Report Total Member
            Route::resource('/total-member', TotalMemberController::class);

            // Report Report Analitic
            Route::resource('/Report-analytic', ReportAnalyticController::class);

            // Dashboard Bartender
            Route::get('/dashboard-bartender', [DashboardBartenderController::class, 'reportBartender'])->name('report.bartender');

    });

    // Route Dashboard Kitchen
    Route::prefix('kitchen')->name('kitchen.')->group(function () {
        // Route::get('/dashboard', function(){
        //     $data['page_title'] = 'dashboard';
        //     return view('process.kitchen.dashboard', $data);
        // })->name('dashboard');

        Route::get('/dashboard', [DashboardKitchenController::class, 'index'])->name('dashboard.kitchen');
        Route::post('/dashboard-status', [DashboardKitchenController::class, 'statusDashboard'])->name('status-dashboard');
        Route::post('/dashboard-status-remove', [DashboardKitchenController::class, 'statusRemove'])->name('status-remove');
        Route::post('/dashboard-status-all', [DashboardKitchenController::class, 'statusDashboardAll'])->name('status-dashboard-all');
        Route::get('/dashboard-detail/{id}', [DashboardKitchenController::class, 'detail'])->name('dashboard.detail');
        // Cetak Pdf
        // Route::get('/dashboard/{$id}', [DashboardKitchenController::class, 'cetak_pdf'])->name('cetak-pdf');
        Route::resource('/dashboard-detail-kitchen', DashboardKitchenController::class);

    });

    // Route Dashboard bartender
    Route::prefix('bartender')->name('bartender.')->group(function () {
        // Route::get('/dashboard', function(){
            //     $data['page_title'] = 'dashboard';
            //     return view('process.bartender.dashboard', $data);
            // })->name('dashboard');
    Route::get('/dashboard', [DashboardBartenderController::class, 'index'])->name('dashboard.bartender');
    Route::post('/dashboard-status', [DashboardBartenderController::class, 'statusDashboard'])->name('status-dashboard');
    Route::post('/dashboard-status-remove', [DashboardBartenderController::class, 'statusRemove'])->name('status-remove');
    Route::post('/dashboard-status-all', [DashboardBartenderController::class, 'statusDashboardAll'])->name('status-bartender-dashboard-all');
    Route::get('/dashboard-detail/{id}', [DashboardBartenderController::class, 'detail'])->name('dashboard.detail');
    Route::get('/dashboard-print/{id}', [DashboardBartenderController::class, 'autoPrintButton'])->name('autoPrintButton');
    Route::resource('/dashboard-detail-bartender', DashboardBartenderController::class);
    });

    // dashboard Waiters
    Route::prefix('waiters')->name('waiters.')->group(function () {
        // Route::get('/dashboard', function(){
        //     $data['page_title'] = 'dashboard';
        //     return view('process.waiters.dashboard', $data);
        // })->name('dashboard');
        Route::get('/dashboard', [DashboardWaiterController::class, 'index'])->name('dashboard.waiters');
        Route::post('/dashboard-status', [DashboardWaiterController::class, 'statusDashboard'])->name('status-dashboard');
        Route::post('/dashboard-status-all', [DashboardWaiterController::class, 'statusDashboardAll'])->name('status-waiters-dashboard-all');
        Route::get('/dashboard-detail/{id}', [DashboardWaiterController::class, 'detail'])->name('dashboard.detail');
        Route::post('/status-update', [DashboardWaiterController::class, 'statusUpdate'])->name('status-update');
        Route::post('/tes', [DashboardWaiterController::class, 'tes'])->name('tes');
    });

    // dashboard Server
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [DashboardServerController::class, 'index'])->name('dashboard.server');
        Route::post('/dashboard-status', [DashboardServerController::class, 'statusDashboard'])->name('status-dashboard');
        Route::post('/dashboard-status-all', [DashboardServerController::class, 'statusDashboardAll'])->name('status-server-dashboard-all');
        Route::get('/dashboard-detail/{id}', [DashboardServerController::class, 'detail'])->name('dashboard.detail');
        Route::post('/status-update', [DashboardServerController::class, 'statusUpdate'])->name('status-update');
        Route::resource('/dashboard-detail-kasir', DashboardServerController::class);
    });


    // Dashboard Server
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/kitchen', [DashboardKitchenController::class, 'history'])->name('history.kitchen');
    });
    // Pdf Kitchen
    // Route::get('/pegawai/cetak_pdf', 'PegawaiController@cetak_pdf');

