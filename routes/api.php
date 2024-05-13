<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ChangeRoleController;
use App\Http\Controllers\Profile\ChangePasswordController;
use App\Http\Controllers\User\ChangePasswordController as UserChangePasswordController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\ResetPasswordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login',[LoginController::class, 'login']);
    Route::post('password/email', [ResetPasswordController::class, 'sendPasswordResetLinkEmail'])->name('password.email');
	Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');
    Route::post('password/checkToken', [ResetPasswordController::class, 'checkToken'])->name('password.checkToken');
});


Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::prefix('auth')->group(function () {
        Route::post('logout', [LogoutController::class,'logout']);
    });

    Route::prefix('profile')->group(function () {
        Route::post('change-password', ChangePasswordController::class);
        Route::post('change-role', ChangeRoleController::class);
    });
    
    Route::singleton('profile', ProfileController::class)->only(['show','update']);

    Route::post('users/change-password/{user}', UserChangePasswordController::class);
    Route::apiResource('users', UserController::class)->middleware('role:ROLE_ADMIN');
});
