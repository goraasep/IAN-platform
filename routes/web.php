<?php

use App\Http\Controllers\admin\AdminController as AdminAdminController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\PanelController as AdminPanelController;
use App\Http\Controllers\admin\ParameterController as AdminParameterController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\admin\ConnectionController as AdminConnectionController;
use App\Http\Controllers\admin\TopicController as AdminTopicController;
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
use App\Http\Controllers\user\DashboardController as UserDashboardController;
use App\Http\Controllers\user\ParameterController as UserParameterController;

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
        //dashboard
        Route::post('/admin-panel/dashboard', [AdminDashboardController::class, 'store']);
        Route::get('/admin-panel/dashboard/{dashboard}', [AdminDashboardController::class, 'show']);
        Route::put('/admin-panel/dashboard/{dashboard}', [AdminDashboardController::class, 'update']);
        Route::delete('/admin-panel/dashboard/{dashboard}', [AdminDashboardController::class, 'destroy']);
        Route::get('/admin-panel/export/dashboard', [AdminDashboardController::class, 'export'])->name('export_dashboard_admin');
        //panel
        Route::post('/admin-panel/panel', [AdminPanelController::class, 'store']);
        Route::put('/admin-panel/panel/{panel}', [AdminPanelController::class, 'update']);
        Route::delete('/admin-panel/panel/{panel}', [AdminPanelController::class, 'destroy']);
        //parameter
        Route::post('/admin-panel/parameter', [AdminParameterController::class, 'store']);
        Route::get('/admin-panel/parameter/{parameter}', [AdminParameterController::class, 'show']);
        Route::post('/admin-panel/parameter/{parameter}', [AdminParameterController::class, 'show']);
        Route::put('/admin-panel/parameter/{parameter}', [AdminParameterController::class, 'update']);
        Route::delete('/admin-panel/parameter/{parameter}', [AdminParameterController::class, 'destroy']);
        Route::get('/admin-panel/export/parameter', [AdminParameterController::class, 'export'])->name('export_parameter_admin');
        //user
        Route::get('/admin-panel/user/{user}', [AdminUserController::class, 'show']);
        Route::post('/admin-panel/user', [AdminUserController::class, 'store']);
        Route::put('/admin-panel/user/{user}', [AdminUserController::class, 'update']);
        Route::delete('/admin-panel/user/{user}', [AdminUserController::class, 'destroy']);
        Route::post('/admin-panel/access', [AdminUserController::class, 'addDashboardAccess']);
        Route::delete('/admin-panel/access/{access}', [AdminUserController::class, 'destroy_access']);
        Route::post('/datatables/access_list', [AdminUserController::class, 'access_list']);

        //connection
        Route::get('/admin-panel/connection/{connection}', [AdminConnectionController::class, 'show']);
        Route::post('/admin-panel/connection', [AdminConnectionController::class, 'store']);
        Route::put('/admin-panel/connection/{connection}', [AdminConnectionController::class, 'update']);
        Route::delete('/admin-panel/connection/{connection}', [AdminConnectionController::class, 'destroy']);
        Route::post('/admin-panel/connection/{connection}/reconnect', [AdminConnectionController::class, 'reconnect']);
        Route::post('/datatables/topic_list', [AdminTopicController::class, 'topic_list']);
        Route::post('/admin-panel/topic', [AdminTopicController::class, 'store']);
        Route::delete('/admin-panel/topic/{topic}', [AdminTopicController::class, 'destroy']);

        Route::post('/datatables/parameter_list', [AdminParameterController::class, 'parameter_list']);
        Route::post('/datatables/dashboard_list', [AdminDashboardController::class, 'dashboard_list']);
        Route::post('/datatables/user_list', [AdminUserController::class, 'user_list']);
        Route::post('/datatables/connection_list', [AdminConnectionController::class, 'connection_list']);


        Route::post('/datatables/historical_log', [AdminParameterController::class, 'historical_log']);
        Route::post('/datatables/alert_log', [AdminParameterController::class, 'alert_log']);

        Route::post('/livedata', [AdminParameterController::class, 'liveData']);
        Route::post('/graphdata', [AdminParameterController::class, 'graphData']);
        Route::post('/connection_status', [AdminConnectionController::class, 'connStatus']);
    });
    Route::middleware('role:User')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index']);
        Route::get('/dashboard/{dashboard}', [UserDashboardController::class, 'show']);
        Route::get('/dashboard/parameter/{parameter}', [UserParameterController::class, 'show']);
        Route::post('/dashboard/parameter/{parameter}', [UserParameterController::class, 'show']);
        Route::get('/export/dashboard', [UserDashboardController::class, 'export'])->name('export_dashboard_user');
        Route::get('/export/parameter', [UserParameterController::class, 'export'])->name('export_parameter_user');

        Route::post('/userlivedata', [UserParameterController::class, 'liveData']);
        Route::post('/usergraphdata', [UserParameterController::class, 'graphData']);
        Route::post('/datatables/user_historical_log', [UserParameterController::class, 'historical_log']);
        Route::post('/datatables/user_alert_log', [UserParameterController::class, 'alert_log']);
        // Route::post('/usergraphdata', [AdminParameterController::class, 'graphData']);
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
