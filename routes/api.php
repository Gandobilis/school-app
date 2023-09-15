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
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::apiResource('/banners', BannerController::class)->only(['index', 'show'])->names('banners');

    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::delete('/unsubscribe/{subscription}', [SubscriptionController::class, 'unsubscribe'])->name('subscriptions.unsubscribe');

    Route::apiResource('/courses', CourseController::class)->only(['index', 'show'])->names('courses');
    Route::post('/courses/{course}/register', [CourseController::class, 'register'])->name('course.register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum'])->name('auth.logout');

        Route::apiResource('/banners', BannerController::class)->except(['index', 'show'])->names('admin.banners');

        Route::apiResource('/subscriptions', SubscriptionController::class)->only('index')->names('admin.subscriptions');

        Route::apiResource('/courses', CourseController::class)->except(['index', 'show'])->names('admin.courses');
        Route::get('/courses/{course}/students', [CourseController::class, 'students'])->name('admin.course.students');

        Route::apiResource('/lecturers', LecturerController::class)->names('admin.lecturers');

        Route::apiResource('/users', UserController::class)->names('admin.users');
    });
});
