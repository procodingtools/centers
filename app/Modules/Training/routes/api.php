<?php

use App\Modules\Training\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Training', 'namespace' => 'App\Modules\Training\Controllers', 'prefix' => 'api/trainings', 'middleware' => 'auth:api'], function() {
    Route::group(['middleware' => 'scope:admin'], function() {
        Route::post('/', [TrainingController::class, 'add']);
        Route::get('/subscribed', [TrainingController::class, 'getSubscribed']);
        Route::get('/certifs', [TrainingController::class, 'myCertifs']);
        Route::post('/certifs', [TrainingController::class, 'manageCertifs']);
        Route::post('/subscribe', [TrainingController::class, 'subscribe']);
        Route::get('/{id}', [TrainingController::class, 'getActive']); // center id
    });
});
