<?php

use App\Modules\User\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'User', 'namespace' => 'App\Modules\User\Controllers', 'prefix' => 'api'], function() {
    Route::prefix('auth')->group(function() {
       Route::post('login', [UserController::class, 'login']);
       Route::post('signup', [UserController::class, 'signup']);
       Route::post('add_employee', [UserController::class, 'AddEmployee'])->middleware(['auth:api', 'scope:admin']);

    });
});
