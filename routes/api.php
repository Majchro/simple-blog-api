<?php

use App\Http\Controllers\Authentication\AuthenticatedSessionController;
use App\Http\Controllers\Authentication\NewPasswordController;
use App\Http\Controllers\Authentication\PasswordResetLinkController;
use App\Http\Controllers\Authentication\RegisterUserController;
use App\Http\Controllers\Editor\AttachmentController;
use App\Http\Controllers\Editor\PostController;
use App\Http\Controllers\Editor\UserController;
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
Route::middleware('guest')->prefix('auth')->name('auth.')->group(function () {
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::post('register', [RegisterUserController::class, 'store'])->name('register');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('forgot-password');
    Route::put('reset-password', [NewPasswordController::class, 'update'])->name('reset-password');
});

Route::middleware('auth', 'can:access-to-editor-panel')->name('editor.')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('attachments', AttachmentController::class)->only('destroy');
    Route::apiResource('users', UserController::class);
    Route::put('users/{id}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');
});
