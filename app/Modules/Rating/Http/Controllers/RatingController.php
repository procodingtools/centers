<?php

namespace App\Modules\Rating\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Rating\Http\Requests\AddRatingRequest;
use App\Repositories\RatingRepository;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    private $ratings;

    /**
     * RatingController constructor.
     * @param $ratings
     */
    public function __construct(RatingRepository $ratings)
    {
        $this->ratings = $ratings;
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Rating::welcome");
    }


    public function getCenter($id) {
        $result = $this->ratings->getCenter($id);

        return response()->json($result);
    }

    public function getAdmin($id) {
        $result = $this->ratings->getAdmin($id);

        return response()->json($result);
    }

    public function add(AddRatingRequest $rq) {
        $result = $this->ratings->add($rq->validated());

        return response()->json($result);
    }


}
