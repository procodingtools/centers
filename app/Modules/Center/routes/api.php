<?php

use App\Modules\Actuality\Http\Controllers\ActualityController;
use App\Modules\Admin\Http\Controllers\AdminController;
use App\Modules\Center\Http\Controllers\CenterController;
use App\Modules\Documentation\Http\Controllers\DocumentationController;
use App\Modules\Product\Http\Controllers\ProductController;
use App\Modules\Rating\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Center', 'namespace' => 'App\Modules\Center\Controllers', 'prefix' => 'api/centers'], function() {
    Route::get('/all', [CenterController::class, 'getAll']);
    Route::group(['middleware' => ['auth:api', 'scope:admin']], function() {
        Route::post('/', [CenterController::class, 'add']);
        Route::get('/me', [CenterController::class, 'getMine']);
        Route::post('/update/{id}', [CenterController::class, 'update']);
        Route::delete('/{id}', [CenterController::class, 'delete']);
    });
    Route::get('/{id}/rating', [RatingController::class, 'getCenter']);
    Route::get('/{id}/employees', [AdminController::class, 'getEmployees']);
    Route::get('/{id}/documentations', [DocumentationController::class, 'getCenterDocumentations']);
    Route::get('/{id}/actualities', [ActualityController::class, 'getCenterActualities']);
    Route::get('/{id}/products', [ProductController::class, 'getCenterProducts']);
});
