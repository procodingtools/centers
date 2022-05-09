<?php

namespace App\Modules\Center\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Center\Http\Requests\AddCenterRequest;
use App\Repositories\CenterRepository;
use Illuminate\Http\Request;

class CenterController extends Controller
{

    private $centers;

    /**
     * CenterController constructor.
     * @param $centers
     */
    public function __construct(CenterRepository $centers)
    {
        $this->centers = $centers;
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Center::welcome");
    }

    public function add(AddCenterRequest $rq) {
        $result = $this->centers->add($rq->validated());

        return response()->json($result);
    }

    public function getMine() {
        $result = $this->centers->getMine();

        return response()->json($result);
    }


    public function getAll() {
        $result = $this->centers->getAll();

        return response()->json($result);
    }


    public function delete($id) {
        try {
            $result = $this->centers->remove($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }


    public function update(AddCenterRequest $rq, $id) {
        try {
            $result = $this->centers->change($rq->validated(), $id);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }
}
