<?php

use App\Modules\Documentation\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Documentation', 'namespace' => 'App\Modules\Documentation\Controllers', 'prefix' => 'api/documentations'], function() {
    Route::get('/', [DocumentationController::class, 'getAll']);
    Route::group(['middleware' => ['auth:api', 'scope:admin']], function () {
        Route::post('/', [DocumentationController::class, 'add']);
        Route::post('/update/{id}', [DocumentationController::class, 'update']);
        Route::delete('/{id}', [DocumentationController::class, 'delete']);

    });
});
