<?php

namespace App\Repositories;

use App\Modules\Admin\Models\Admin;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Client\Models\Client;
use App\Modules\Rating\Models\Rating;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class AppointmentRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Appointment::class;
    }


    public function add($rq)
    {
        $appointment = new Appointment();
        $appointment->client_id = Client::whereUserId(Auth::id())->get()->first()->id;
        $appointment->admin_id = $rq['employee_id'];
        unset($rq['employee_id']);

        $start = Carbon::parse($rq['start']);

        $appointment->start = $start;
        $appointment->end = $start->addMinutes(30);

        $appointment->save();

        return $appointment;
    }


    public function getMyAppointments()
    {
        $client = Client::whereUserId(Auth::id())->get()->first();
        $admin = Admin::whereUserId(Auth::id())->get()->first();

        if (!is_null($client)) {
            $appointments = Appointment::with(['admin'])->whereClientId($client->id)->get();
        } else
            $appointments = Appointment::with(['client'])->whereAdminId($admin->id)->get();

        return $appointments;
    }


    /**
     * @param $id
     * @return mixed
     * @throws ErrorException
     */
    public function getReservedAppointments($id) {
        try {
            Admin::findOrFail($id);
        } catch(\Throwable $e) {
            throw new ErrorException('Employee not found', Response::HTTP_NOT_FOUND);
        }

        $appointments = Appointment::whereAdminId(id)->where('start', '>', Carbon::now())->get();

        return $appointments;
    }






}
