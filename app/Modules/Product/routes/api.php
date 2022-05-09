<?php

use App\Modules\Product\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Product', 'namespace' => 'App\Modules\Product\Controllers', 'prefix' => 'api/products'], function() {
    Route::get('/', [ProductController::class, 'getAll']);
    Route::get('/{id}', [ProductController::class, 'getById']);
    Route::group(['middleware' => ['auth:api', 'scope:admin']], function() {
        Route::post('/', [ProductController::class, 'add']);
        Route::post('/update/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
    });
});
