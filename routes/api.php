<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\SubscriptionController;
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
Route::middleware('locale')->group(function () {
    Route::apiResource('/banners', BannerController::class)->only(['index', 'show'])->names('banners');

    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::delete('/unsubscribe/{subscription}', [SubscriptionController::class, 'unsubscribe'])->name('subscriptions.unsubscribe');

    Route::post('/courses/{course}/register', [CourseController::class, 'register'])->name('course.register');

    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/subscriptions', SubscriptionController::class)->only('index')->names('admin.subscriptions');

        Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum'])->name('auth.logout');

        Route::apiResource('/users', UserController::class)->names('admin.users');
        Route::apiResource('/lecturers', LecturerController::class)->names('admin.lecturers');
        Route::apiResource('/courses', CourseController::class)->names('admin.courses');

        Route::apiResource('/banners', BannerController::class)->except(['index', 'show'])->names('admin.banners');
    });

});
