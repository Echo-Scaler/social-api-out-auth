<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SocialPostController;
use App\Http\Controllers\Api\CategoryController;

// Fully RESTful API for SocialPosts
Route::apiResource('social-posts', SocialPostController::class);
Route::apiResource('categories', CategoryController::class);

Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Social API is running!',
        'endpoints' => [
            'GET /api/social-posts' => 'List all posts',
            'POST /api/social-posts' => 'Create a new post',
            'GET /api/social-posts/{id}' => 'View a specific post',
            'PUT /api/social-posts/{id}' => 'Update a post',
            'DELETE /api/social-posts/{id}' => 'Delete a post',
        ]
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
