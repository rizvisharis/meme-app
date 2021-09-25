<?php

use App\Http\Controllers\AuthenticateController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('auth')
    ->group(function () {
        Route::post('/login', [AuthenticateController::class,'login']);
        Route::post('/forgot-password', [AuthenticateController::class,'forgotPassword']);
        Route::post('/password-reset', [AuthenticateController::class,'passwordReset']);
    });
