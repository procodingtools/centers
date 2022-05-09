<?php

use App\Modules\Appointment\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Appointment', 'namespace' => 'App\Modules\Appointment\Controllers', 'prefix' => 'api/appointments', 'middleware' => 'auth:api'], function () {
    Route::get('/', [AppointmentController::class, 'getMyAppointments']);
    Route::get('/{id}', [AppointmentController::class, 'getReservedAppointments']);
    Route::post('/', [AppointmentController::class, 'add']);
});
