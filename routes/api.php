<?php

use App\Http\Controllers\API\APIDashboardController;
use App\Http\Controllers\API\APILoginController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('1.0.0/login', function () {
    return response()->json([
        'status' => 'failed',
        'message' => 'You need token'
    ], 400);
})->name('login');

Route::post('1.0.0/login', [APILoginController::class, 'login'])->name('api_login');

Route::middleware('auth:sanctum')->group(function () {
    // Route::middleware('role:Admin')->group(function () {
    // });
    Route::middleware('role:User')->group(function () {
        Route::get('1.0.0/get_dashboards', [APIDashboardController::class, 'get_dashboards']);
        Route::get('1.0.0/get_panels/{dashboard}', [APIDashboardController::class, 'get_panels']);
        Route::post('1.0.0/logout', [APILoginController::class, 'logout'])->name('api_logout');
    });
});
