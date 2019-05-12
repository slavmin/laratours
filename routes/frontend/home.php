<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\TeamManageController;
// Tour controllers
use App\Http\Controllers\Frontend\Tour\TypeController;
use App\Http\Controllers\Frontend\Tour\CountryController;
use App\Http\Controllers\Frontend\Tour\CityController;
use App\Http\Controllers\Frontend\Tour\GuideController;
use App\Http\Controllers\Frontend\Tour\AttendantController;
use App\Http\Controllers\Frontend\Tour\MuseumController;

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
    Route::group(['namespace' => 'Tour', 'as' => 'tour.'], function () {

        // Tour types Management
        Route::get('tours/type', [TypeController::class, 'index'])->name('type.index');
        Route::get('tours/type/create', [TypeController::class, 'create'])->name('type.create');
        Route::post('tours/type', [TypeController::class, 'store'])->name('type.store');

        Route::group(['prefix' => 'tours/type/{type}'], function () {
            Route::get('edit', [TypeController::class, 'edit'])->name('type.edit');
            Route::patch('/', [TypeController::class, 'update'])->name('type.update');
            Route::delete('/', [TypeController::class, 'destroy'])->name('type.destroy');
        });

        // Country Management
        Route::get('tours/country', [CountryController::class, 'index'])->name('country.index');
        Route::get('tours/country/create', [CountryController::class, 'create'])->name('country.create');
        Route::post('tours/country', [CountryController::class, 'store'])->name('country.store');

        Route::group(['prefix' => 'tours/country/{country}'], function () {
            Route::get('edit', [CountryController::class, 'edit'])->name('country.edit');
            Route::patch('/', [CountryController::class, 'update'])->name('country.update');
            Route::delete('/', [CountryController::class, 'destroy'])->name('country.destroy');
            // Deleted
            Route::get('restore', [CountryController::class, 'restore'])->name('country.restore');
            Route::delete('delete', [CountryController::class, 'delete'])->name('country.delete-permanently');

            // City Management
            Route::get('city', [CityController::class, 'index'])->name('city.index');
            Route::get('city/create', [CityController::class, 'create'])->name('city.create');
            Route::post('city', [CityController::class, 'store'])->name('city.store');

            Route::group(['prefix' => 'city/{city}'], function () {
                Route::get('edit', [CityController::class, 'edit'])->name('city.edit');
                Route::patch('/', [CityController::class, 'update'])->name('city.update');
                Route::delete('/', [CityController::class, 'destroy'])->name('city.destroy');
            });
        });

        // Tour Guides Management
        Route::get('tours/guide', [GuideController::class, 'index'])->name('guide.index');
        Route::get('tours/guide/create', [GuideController::class, 'create'])->name('guide.create');
        Route::post('tours/guide', [GuideController::class, 'store'])->name('guide.store');

        Route::group(['prefix' => 'tours/guide/{guide}'], function () {
            Route::get('edit', [GuideController::class, 'edit'])->name('guide.edit');
            Route::patch('/', [GuideController::class, 'update'])->name('guide.update');
            Route::delete('/', [GuideController::class, 'destroy'])->name('guide.destroy');
        });

        // Tour Attendants Management
        Route::get('tours/attendant', [AttendantController::class, 'index'])->name('attendant.index');
        Route::get('tours/attendant/create', [AttendantController::class, 'create'])->name('attendant.create');
        Route::post('tours/attendant', [AttendantController::class, 'store'])->name('attendant.store');

        Route::group(['prefix' => 'tours/attendant/{attendant}'], function () {
            Route::get('edit', [AttendantController::class, 'edit'])->name('attendant.edit');
            Route::patch('/', [AttendantController::class, 'update'])->name('attendant.update');
            Route::delete('/', [AttendantController::class, 'destroy'])->name('attendant.destroy');
        });

        // Tour Museum Management
        Route::get('tours/museum', [MuseumController::class, 'index'])->name('museum.index');
        Route::get('tours/museum/create', [MuseumController::class, 'create'])->name('museum.create');
        Route::post('tours/museum', [MuseumController::class, 'store'])->name('museum.store');

        Route::group(['prefix' => 'tours/museum/{museum}'], function () {
            Route::get('edit', [MuseumController::class, 'edit'])->name('museum.edit');
            Route::patch('/', [MuseumController::class, 'update'])->name('museum.update');
            Route::delete('/', [MuseumController::class, 'destroy'])->name('museum.destroy');
        });

    });
});
