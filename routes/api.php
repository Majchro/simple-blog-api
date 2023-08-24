<?php

use App\Http\Controllers\Authentication\AuthenticatedSessionController;
use App\Http\Controllers\Authentication\NewPasswordController;
use App\Http\Controllers\Authentication\PasswordResetLinkController;
use App\Http\Controllers\Authentication\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->name('auth.')->group(function () {
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::post('register', [RegisterUserController::class, 'store'])->name('register');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('forgot-password');
    Route::put('reset-password', [NewPasswordController::class, 'update'])->name('reset-password');
});

Route::middleware('auth', 'can:access-to-editor-panel')->group(function () {

});
