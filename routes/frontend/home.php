<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\TeamManageController;

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
});
