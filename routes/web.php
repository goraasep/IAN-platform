<?php

use App\Http\Controllers\admin\AdminController as AdminAdminController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\PanelController as AdminPanelController;
use App\Http\Controllers\admin\ParameterController as AdminParameterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatatablesController;
use App\Http\Controllers\TestController;
use App\Models\Devices;
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


// Route::resource('/', DashboardController::class)->middleware('auth');
// Route::post('/sitemap', [DashboardController::class, 'siteMap'])->middleware('auth');
// Route::post('/alldevices', [DatatablesController::class, 'allDevices'])->middleware('auth');
// Route::post('/allsites', [DatatablesController::class, 'allSites'])->middleware('auth');
// Route::post('/allparameters', [DatatablesController::class, 'allParameters'])->middleware('auth');
// Route::post('/allalerts', [DatatablesController::class, 'allAlerts'])->middleware('auth');
// Route::post('/historicallog', [DatatablesController::class, 'historicalLog'])->middleware('auth');
// Route::resource('/devices', DevicesController::class)->middleware('auth');
// Route::resource('/parameter', ParameterController::class)->middleware('auth');
// //livedata
// Route::post('livedata', [ParameterController::class, 'liveData'])->middleware('auth');
// Route::post('livedata_once', [ParameterController::class, 'liveDataOnce'])->middleware('auth');
// Route::post('livedata_overview', [ParameterController::class, 'liveDataOverview'])->middleware('auth');
// Route::post('livedata_special', [ParameterController::class, 'liveDataSpecial'])->middleware('auth');

// Route::resource('/sites', SitesController::class)->middleware('auth');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin-panel', [AdminAdminController::class, 'index']);
        Route::post('/admin-panel/dashboard', [AdminDashboardController::class, 'store']);
        Route::get('/admin-panel/dashboard/{dashboard}', [AdminDashboardController::class, 'show']);
        Route::post('/admin-panel/panel', [AdminPanelController::class, 'store']);
        Route::post('/datatables/parameter_list', [AdminParameterController::class, 'parameter_list']);
        Route::post('/datatables/dashboard_list', [AdminDashboardController::class, 'dashboard_list']);
    });
    Route::middleware('role:User')->group(function () {
        Route::resource('/', DashboardController::class);
    });
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/test', [TestController::class, 'test']);
Route::get('/account', [LoginController::class, 'showAccount'])->middleware('auth');
Route::post('/update_password', [LoginController::class, 'updatePassword'])->middleware('auth');
// Route::get('/test', function () {
//     return view('test', [
//         'title' => 'test',
//         'breadcrumb' => 'test'
//     ]);
// });
// Route::post('/alldevice', [DatatablesController::class, 'allDevice'])->middleware('auth');
