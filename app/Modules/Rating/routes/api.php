<?php

use App\Modules\Rating\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Rating', 'namespace' => 'App\Modules\Rating\Controllers', 'prefix' => 'api/ratings'], function() {
    Route::get('/employees/{id}', [RatingController::class, 'getAdmin']);
    Route::get('/centers/{id}', [RatingController::class, 'getCenter']);
    Route::post('/', [RatingController::class, 'add'])->middleware(['auth:api', 'scope:client']);

});
