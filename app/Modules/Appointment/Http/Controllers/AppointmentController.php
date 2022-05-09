<?php

namespace App\Modules\Appointment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Http\Requests\AddAppointmentRequest;
use App\Repositories\AppointmentRepository;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    private $appointments;

    /**
     * AppointmentController constructor.
     * @param $appointments
     */
    public function __construct(AppointmentRepository $appointments)
    {
        $this->appointments = $appointments;
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Appointment::welcome");
    }

    public function add(AddAppointmentRequest $rq) {
        $result = $this->appointments->add($rq->validated());

        return response()-json($result);
    }

    public function getMyAppointments() {
        $result = $this->appointments->getMyAppointments();

        return response()->json($result);
    }

    public function getReservedAppointments($id) {
        try {
            $result = $this->appointments->getReservedAppointments($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }
}
