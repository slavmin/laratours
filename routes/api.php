<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Tour\TourOptionsController;
use App\Http\Controllers\Api\Document\LabelsController;
use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login', [AuthController::class, 'login'])->name('api-login');
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api-logout');
    Route::get('/tour-options', [TourOptionsController::class, 'getOptions'])->name('api-tour-options');
    Route::get('/label-options', [LabelsController::class, 'getInfo'])->name('api-label-options');
});