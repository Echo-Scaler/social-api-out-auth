<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;

Route::get('/metrics', [DashboardController::class, 'getMetrics']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
