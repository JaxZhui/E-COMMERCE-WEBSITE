<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;

Route::prefix('v1')->group(function () {
    
    // Product routes for Vue.js frontend
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::get('products/category/{categoryId}', [ProductController::class, 'getByCategory']);
    
    // Category routes for Vue.js frontend
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    
    // Contact routes
    Route::post('contact', [ContactController::class, 'store']);
    Route::get('contacts', [ContactController::class, 'index']);
    Route::get('contacts/{contact}', [ContactController::class, 'show']);
    
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
