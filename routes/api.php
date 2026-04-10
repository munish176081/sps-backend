<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GalleryController;

Route::post('/leads', [LeadController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/products/subcategories', [ProductController::class, 'subcategories']);
Route::get('/stone-data', [ProductController::class, 'stoneData']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

Route::get('/test', function () {
    return 'API working';
});