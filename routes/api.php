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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\PriceSignController;
use App\Http\Controllers\CurrencyTypeController;
use App\Http\Controllers\ProductController;
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
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('password/email', [ResetPasswordController::class, 'sendPasswordResetLinkEmail'])->name('password.email');
    Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');
    Route::post('password/checkToken', [ResetPasswordController::class, 'checkToken'])->name('password.checkToken');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('auth')->group(function () {
        Route::post('logout', [LogoutController::class, 'logout']);
    });

    Route::prefix('profile')->group(function () {
        Route::post('change-password', [ChangePasswordController::class, 'changePassword']);
        Route::post('change-role', [ChangeRoleController::class, 'changeRole']);
    });

    Route::resource('profile', ProfileController::class)->only(['show', 'update']);

    Route::post('users/change-password/{user}', [UserChangePasswordController::class, 'changePassword']);
    Route::apiResource('users', UserController::class)->middleware('role:ROLE_ADMIN');

    Route::apiResource('brands', BrandController::class)->except(['destroy', 'show']);
    Route::apiResource('categories', CategoryController::class)->except(['destroy', 'show']);
    Route::apiResource('product_types', ProductTypeController::class)->except(['destroy', 'show']);
    Route::apiResource('price_signs', PriceSignController::class)->except(['destroy', 'show']);
    Route::apiResource('currency_types', CurrencyTypeController::class)->except(['destroy', 'show']);
    Route::apiResource('products', ProductController::class)->except(['destroy', 'show']);
});
