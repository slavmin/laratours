<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Tour\DetailedTourController;
use App\Http\Controllers\Api\Tour\TourOptionsController;
use App\Http\Controllers\Api\Tour\PartnerTourController;
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

  Route::post('/update-partner-tour-data', [PartnerTourController::class, 'updatePartnerTourData'])->name('update-partner-tour-data');

  Route::post('/create-partner-tour-price', [PartnerTourController::class, 'createPartnerTourPrice'])->name('create-partner-tour-price');
  Route::get('/get-partner-tour-prices', [PartnerTourController::class, 'getPartnerTourPrices'])->name('get-partner-tour-prices');
  Route::post('/edit-partner-tour-price', [PartnerTourController::class, 'editPartnerTourPrice'])->name('edit-partner-tour-price');
  Route::post('/delete-partner-tour-price', [PartnerTourController::class, 'deletePartnerTourPrice'])->name('delete-partner-tour-price');

  Route::get('/get-detailed-tour-objects', [DetailedTourController::class, 'getDetailedTourObjects'])->name('get-detailed-tour-objects');
});
