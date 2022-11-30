<?php

use App\Http\Controllers\DevicesController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatatablesController;
use App\Http\Controllers\TestController;
use App\Models\Devices;

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
    return view('dashboard.index', [
        'title' => 'Home',
        'breadcrumb' => 'Dashboard',
        'subtitle' => 'test'
    ]);
})->middleware('auth');
// Route::get('/devices/device/{devices:uuid}', [DevicesController::class, 'showDevice'])->middleware('auth');
// Route::get('/devices/{devices:uuid}/', [DevicesController::class, 'showDevice'])->middleware('auth');
Route::post('/alldevices', [DatatablesController::class, 'allDevices'])->middleware('auth');
Route::post('/allsites', [DatatablesController::class, 'allSites'])->middleware('auth');
Route::post('/allparameters', [DatatablesController::class, 'allParameters'])->middleware('auth');
Route::post('/allalerts', [DatatablesController::class, 'allAlerts'])->middleware('auth');
Route::post('/historicallog', [DatatablesController::class, 'historicalLog'])->middleware('auth');
Route::resource('/devices', DevicesController::class)->middleware('auth');
Route::resource('/parameter', ParameterController::class)->middleware('auth');
Route::post('livedata', [ParameterController::class, 'liveData'])->middleware('auth');
Route::post('livedata_overview', [ParameterController::class, 'liveDataOverview'])->middleware('auth');

Route::resource('/sites', SitesController::class)->middleware('auth');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/test', [TestController::class, 'test']);
// Route::get('/test', function () {
//     return view('test', [
//         'title' => 'test',
//         'breadcrumb' => 'test'
//     ]);
// });
// Route::post('/alldevice', [DatatablesController::class, 'allDevice'])->middleware('auth');
