<?php

namespace App\Repositories;

use App\Models\User;
use App\Modules\Actuality\Models\Actuality;
use App\Modules\Admin\Models\Admin;
use App\Modules\Center\Models\Center;
use App\Modules\Training\Models\Training;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class TrainingRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Training::class;
    }




    public function add($rq) {
        $date = $rq['start_date'];
        unset($rq['start_date']);

        $training = new Training();

        foreach ($rq as $key => $val) {
            $training->$key = $val;
        }

        $training->start_date = Carbon::parse($date);

        $training->save();

        return $training;
    }

    public function getActive($centerId) {
        $trainings = Training::whereFinished(false)->whereCenterId($centerId)->get();

        return $trainings;
    }

    public function getSubscribed() {
        $trainings = Training::whereHas('admins', function($q) {
            $q->whereAdminId(Admin::whereUserId(Auth::id())->get()->first()->id);
        })->whereFinished(false)->get();

        return $trainings;
    }

    public function getMyCertificates() {
        $certifs = Training::whereHas('admins', function($q) {
            $q->whereAdminId(Admin::whereUserId(Auth::id())->get()->first()->id)->whereGranted(true);
        })->get();

        return $certifs;
    }

    public function manageCertificates($rq) {
        $train = Training::whereHas('admins', function($q) use ($rq) {
            $q->whereAdminId($rq['admin_id']);
        })->find($rq['training_id']);

        $train->admins->first()->pivot->granted = $rq['granted'];

        $train->admins->first()->pivot->save();

        $train->save();

        return $train;
    }

    public function subscribeToTraining($rq) {
        $train = Training::find($rq['training_id']);

        $train->admins()->save(User::find(Auth::id()));

        return $train;
    }

}
