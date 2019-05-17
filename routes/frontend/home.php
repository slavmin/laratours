<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\TeamManageController;
// Tour controllers
use App\Http\Controllers\Frontend\Tour\TypeController;
use App\Http\Controllers\Frontend\Tour\CustomerTypeController;
use App\Http\Controllers\Frontend\Tour\HotelCategoryController;
use App\Http\Controllers\Frontend\Tour\CountryController;
use App\Http\Controllers\Frontend\Tour\CityController;
use App\Http\Controllers\Frontend\Tour\GuideController;
use App\Http\Controllers\Frontend\Tour\AttendantController;
use App\Http\Controllers\Frontend\Tour\HotelController;
use App\Http\Controllers\Frontend\Tour\MuseumController;
use App\Http\Controllers\Frontend\Tour\MealController;
use App\Http\Controllers\Frontend\Tour\TransportController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // User Team Specific
        Route::get('team', [TeamManageController::class, 'index'])->name('team');
        Route::get('team/edit', [TeamManageController::class, 'edit'])->name('team.edit');
        Route::patch('team/edit/{team_id}', [TeamManageController::class, 'update'])->name('team.edit.post');
        Route::post('team/invite/{team_id}', [TeamManageController::class, 'invite'])->name('team.invite');
        Route::get('team/resend/{invite_id}', [TeamManageController::class, 'resendInvite'])->name('team.resend_invite');
        Route::get('team/invite/{invite_id}/delete', [TeamManageController::class, 'deleteInvite'])->name('team.delete_invite');
        Route::delete('team/members/{user_id}/delete', [TeamManageController::class, 'deleteMember'])->name('team.members.destroy');
    });

    // Tours Management
    Route::group(['namespace' => 'Tour', 'as' => 'tour.', 'prefix' => 'tours'], function () {

        // Tour types Management
        Route::resource('type', \TypeController::class, ['except' => ['show']]);
        // Handle Soft Deleted
        Route::group(['prefix' => 'type/{type}'], function () {
            Route::get('restore', [TypeController::class, 'restore'])->name('type.restore');
            Route::delete('delete', [TypeController::class, 'delete'])->name('type.delete-permanently');
        });

        // Tour customer types Management
        Route::resource('customer-type', \CustomerTypeController::class, ['except' => ['show']]);
        // Handle Soft Deleted
        Route::group(['prefix' => 'customer-type/{customer_type}'], function () {
            Route::get('restore', [CustomerTypeController::class, 'restore'])->name('customer-type.restore');
            Route::delete('delete', [CustomerTypeController::class, 'delete'])->name('customer-type.delete-permanently');
        });

        // Tour hotels category Management
        Route::resource('hotel-category', \HotelCategoryController::class, ['except' => ['show']]);
        // Handle Soft Deleted
        Route::group(['prefix' => 'hotel-category/{hotel_category}'], function () {
            Route::get('restore', [HotelCategoryController::class, 'restore'])->name('hotel-category.restore');
            Route::delete('delete', [HotelCategoryController::class, 'delete'])->name('hotel-category.delete-permanently');
        });

        // Country Management
        Route::resource('country', \CountryController::class, ['except' => ['show']]);
        // Handle Soft Deleted
        Route::group(['prefix' => 'country/{country}'], function () {
            Route::get('restore', [CountryController::class, 'restore'])->name('country.restore');
            Route::delete('delete', [CountryController::class, 'delete'])->name('country.delete-permanently');

            // City Management
            Route::resource('city', \CityController::class, ['except' => ['show']]);
            // Handle Soft Deleted
            Route::group(['prefix' => 'city/{city}'], function () {
                Route::get('restore', [CityController::class, 'restore'])->name('city.restore');
                Route::delete('delete', [CityController::class, 'delete'])->name('city.delete-permanently');
            });
        });

        // Tour Museum Management
        Route::resource('museum', \MuseumController::class, ['except' => ['show']]);
        // Handle Soft Deleted
        Route::group(['prefix' => 'museum/{museum}'], function () {
            Route::get('restore', [MuseumController::class, 'restore'])->name('museum.restore');
            Route::delete('delete', [MuseumController::class, 'delete'])->name('museum.delete-permanently');
        });

        // Tour Meals Management
        Route::resource('meal', \MealController::class, ['except' => ['show']]);
        // Handle Soft Deleted
        Route::group(['prefix' => 'meal/{meal}'], function () {
            Route::get('restore', [MealController::class, 'restore'])->name('meal.restore');
            Route::delete('delete', [MealController::class, 'delete'])->name('meal.delete-permanently');
        });

        // Tour Hotels Management
        Route::resource('hotel', \HotelController::class, ['except' => ['show']]);
        // Handle Soft Deleted
        Route::group(['prefix' => 'hotel/{hotel}'], function () {
            Route::get('restore', [HotelController::class, 'restore'])->name('hotel.restore');
            Route::delete('delete', [HotelController::class, 'delete'])->name('hotel.delete-permanently');
        });

        // Tour Transport Management
        Route::resource('transport', \TransportController::class, ['except' => ['show']]);
        // Handle Soft Deleted
        Route::group(['prefix' => 'transport/{transport}'], function () {
            Route::get('restore', [TransportController::class, 'restore'])->name('transport.restore');
            Route::delete('delete', [TransportController::class, 'delete'])->name('transport.delete-permanently');
        });

        // Tour Guides Management
        Route::resource('guide', \GuideController::class, ['except' => ['show']]);

        // Tour Attendants Management
        Route::resource('attendant', \AttendantController::class, ['except' => ['show']]);

    });
});
