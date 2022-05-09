<?php

namespace App\Modules\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Training\Http\Requests\AddCertificateRequest;
use App\Modules\Training\Http\Requests\AddTrainingRequest;
use App\Modules\Training\Http\Requests\AddTrainingSubscriptionRequest;
use App\Repositories\TrainingRepository;
use Illuminate\Http\Request;

class TrainingController extends Controller
{

    private $trainings;

    /**
     * TrainingController constructor.
     * @param $trainings
     */
    public function __construct(TrainingRepository $trainings)
    {
        $this->trainings = $trainings;
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Training::welcome");
    }


    public function add(AddTrainingRequest $rq) {
        $train = $this->trainings->add($rq->validated());
        return response()->json($train);
    }

    public function getActive($id) {
        $train = $this->trainings->getActive($id);
        return response()->json($train);
    }

    public function getSubscribed() {
        $train = $this->trainings->getSubscribed();
        return response()->json($train);
    }

    public function myCertifs() {
        $train = $this->trainings->getMyCertificates();
        return response()->json($train);
    }

    public function manageCertifs(AddCertificateRequest $rq) {
        $train = $this->trainings->manageCertificates($rq->validated());
        return response()->json($train);
    }

    public function subscribe(AddTrainingSubscriptionRequest $rq) {
        $train = $this->trainings->subscribeToTraining($rq->validated());
        return response()->json($train);
    }

}
