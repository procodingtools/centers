<?php

namespace App\Modules\Actuality\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Actuality\Http\Requests\AddActualityRequest;
use App\Repositories\ActualityRepository;
use Illuminate\Http\Request;

class ActualityController extends Controller
{
    /**
     * ActualityController constructor.
     * @param $actualities
     */
    public function __construct(ActualityRepository $actualities)
    {
        $this->actualities = $actualities;
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Actuality::welcome");
    }

    private $actualities;




    public function getAll() {
        $response = $this->actualities->getAll();
        return response()->json($response);
    }

    public function add(AddActualityRequest $rq) {
        try {
            $actuality = $this->actualities->add($rq->validated());
        } catch (\ErrorException $e) {
            response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($actuality);
    }

    public function getCenterActualities($id) {

        try {
            $result = $this->actualities->getCenterActualities($id);
        } catch (\ErrorException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json($result);
    }

    public function update(AddActualityRequest $rq, $id) {
        try {
            $result = $this->actualities->change($rq->validated(), $id);
        } catch (\ErrorException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json($result);
    }

    public function remove($id) {
        try {
            $result = $this->actualities->delete($id);
        } catch (\ErrorException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json($result);
    }
}
