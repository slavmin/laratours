<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Tour\DetailedTourController;
use App\Http\Controllers\Api\Tour\TourOptionsController;
use App\Http\Controllers\Api\Tour\PartnerTourController;
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
    Route::get('/tour-countries-with-cities', [TourOptionsController::class, 'getCountriesWithCities'])->name('tour-countries-with-cities');

    Route::post('/update-partner-tour-data', [PartnerTourController::class, 'updatePartnerTourData'])->name('update-partner-tour-data');

    Route::post('/create-partner-tour-price', [PartnerTourController::class, 'createPartnerTourPrice'])->name('create-partner-tour-price');
    Route::get('/get-partner-tour-prices', [PartnerTourController::class, 'getPartnerTourPrices'])->name('get-partner-tour-prices');
    Route::post('/edit-partner-tour-price', [PartnerTourController::class, 'editPartnerTourPrice'])->name('edit-partner-tour-price');
    Route::post('/delete-partner-tour-price', [PartnerTourController::class, 'deletePartnerTourPrice'])->name('delete-partner-tour-price');

    Route::get('/get-detailed-tour-objects', [DetailedTourController::class, 'getDetailedTourObjects'])->name('get-detailed-tour-objects');
    Route::get('/get-detailed-tour-object-attribute-prices', [DetailedTourController::class, 'getDetailedTourObjectAttributePrices'])->name('get-detailed-tour-object-attribute-prices');
    Route::post('/add-detailed-tour-object-attribute', [DetailedTourController::class, 'addDetailedTourObjectAttribute'])->name('add-detailed-tour-object-attribute');
    Route::get('/get-detailed-tour-excursions', [DetailedTourController::class, 'getDetailedTourExcursions'])->name('get-detailed-tour-excursions');
    Route::post('/add-or-update-detailed-tour-extra', [DetailedTourController::class, 'addOrUpdateDetailedTourExtra'])->name('add-or-detailed-tour-extra');
    Route::get('/get-detailed-tour-extra', [DetailedTourController::class, 'getDetailedTourExtras'])->name('get-detailed-tour-extra');
    Route::post('/delete-detailed-tour-extra', [DetailedTourController::class, 'deleteDetailedTourExtra'])->name('delete-detailed-tour-extra');
    Route::get('/get-detailed-tour-object-attribute-properties', [DetailedTourController::class, 'getDetailedTourObjectAttributeProperties'])->name('add-detailed-tour-object-attribute-properties');
    Route::post('/remove-detailed-tour-object-attribute', [DetailedTourController::class, 'removeDetailedTourObjectAttribute'])->name('remove-detailed-tour-object-attribute');
    Route::post('/update-detailed-tour-object-attribute-property', [DetailedTourController::class, 'updateDetailedTourObjectAttributeProperty'])->name('update-detailed-tour-object-attribute-property');
    Route::post('/save-detailed-tour-prices', [DetailedTourController::class, 'saveDetailedTourPrices'])->name('save-detailed-tour-prices');
    Route::get('/get-detailed-tour-data-for-editor', [DetailedTourController::class, 'getTourDataForEditor'])->name('get-detailed-tour-data-for-editor');
    Route::post('/save-detailed-tour-program', [DetailedTourController::class, 'saveDetailedTourProgram'])->name('save-detailed-tour-program');
    Route::get('/label-options', [LabelsController::class, 'getInfo'])->name('api-label-options');
});
