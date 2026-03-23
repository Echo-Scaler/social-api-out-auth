<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\WebDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Web UI CRUD
    Route::resource('social-posts', \App\Http\Controllers\SocialPostController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::get('/api-hub', function () {
        return view('api-management');
    })->name('api.hub');
});

require __DIR__.'/auth.php';
