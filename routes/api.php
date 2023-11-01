<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\Categories\CategoryController;
use App\Http\Controllers\Api\Categories\ParentCategoryController;
use App\Http\Controllers\Api\Categories\SubCategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::group(['middleware' => "auth:sanctum"], function (){
    Route::post('parent_category', [ParentCategoryController::class, 'store']);
    Route::post('category', [CategoryController::class, 'store']);
    Route::post('sub-category', [SubCategoryController::class, 'store']);
    Route::post('product',[ProductController::class, 'store']);

    // Cart
    Route::prefix('cart')->name('cart.')->group(function (){
        Route::post('add', [CartController::class, 'add']);
        Route::put('update/{cart}', [CartController::class, 'update']);
        Route::delete('remove/{cart}', [CartController::class, 'destroy']);
    });

    // Order
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders', [OrderController::class, 'store']);
});

    // Category
    Route::get('parent_category', [ParentCategoryController::class, 'index']);
    Route::get('category', [CategoryController::class, 'index']);
    Route::get('sub-category', [SubCategoryController::class, 'index']);

    // Product
    Route::prefix('product')->name('products.')->group(function (){
        Route::get('',[ProductController::class, 'index']);
        Route::get('show-by-category/{parentCategory}', [ProductController::class, 'show_by_category']);
        Route::get('show_by_slug', [ProductController::class, 'show_by_slug']);
    });
