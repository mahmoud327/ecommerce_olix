<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Refactoring\ProductController;
use App\Http\Controllers\Api\Refactoring\VersionController;
use App\Http\Controllers\Api\Refactoring\ProductImageController;
use App\Http\Controllers\Api\Refactoring\My\ProductController as MyProductController;

Route::group([
    'prefix' => 'v1',
    'as'     => 'v1.',
], function () {
    Route::get('versions', VersionController::class)->name('versions');

    Route::get('products-count', [ProductController::class, 'count'])->name('products.count');
    Route::apiResource('products', ProductController::class)->only(['index', 'show']);

    Route::post('products/{product}/images/{image}/mark-featured', [ProductImageController::class, 'markFeatured'])->name('products.images.markFeatured');
    Route::apiResource('products.images', ProductImageController::class)->except(['update', 'show']);

    Route::group(['middleware' => 'auth:api', 'prefix' => 'my', 'as' => 'my.'], function () {
        Route::get('products-temp', [MyProductController::class, 'getTemp'])->name('products.temp');
        Route::get('products-count', [MyProductController::class, 'count'])->name('products.count');
        Route::apiResource('products', MyProductController::class);
    });
});
