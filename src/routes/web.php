<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\YandexController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Welcome', [
		'canLogin' => Route::has('login'),
		'canRegister' => Route::has('register'),
		'laravelVersion' => Application::VERSION,
		'phpVersion' => PHP_VERSION,
	]);
});

Route::get('/dashboard', function () {
	return Inertia::render('App');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/yandex/settings', [YandexController::class, 'settings']);
    Route::put('/yandex/settings', [YandexController::class, 'update']);

    Route::get('/reviews', [ReviewController::class, 'getReviewsForUser']);
});

require __DIR__.'/auth.php';
