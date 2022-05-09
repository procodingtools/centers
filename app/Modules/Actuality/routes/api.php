<?php

use App\Modules\Actuality\Http\Controllers\ActualityController;
use App\Modules\User\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Actuality', 'namespace' => 'App\Modules\Actuality\Controllers', 'prefix' => 'api/actualities'], function() {
    Route::get('/', [ActualityController::class, 'getAll']);
    Route::group(['middleware' => ['auth:api', 'scope:admin']], function() {
        Route::post('/', [ActualityController::class, 'add']);
        Route::post('/update/{id}', [ActualityController::class, 'update']);
        Route::delete('/{id}', [ActualityController::class, 'remove']);
    });
});
