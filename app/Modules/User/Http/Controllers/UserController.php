<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Http\Requests\AddEmployeeRequest;
use App\Modules\User\Http\Requests\LoginRequest;
use App\Modules\User\Http\Requests\SignupRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    private $users;

    /**
     * UserController constructor.
     * @param $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }


    public function login(LoginRequest $rq) {
        return $this->users->login($rq->validated());
    }

    public function signup(SignupRequest $rq) {
        try {
            $response = $this->users->signup($rq->validated());
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($response);
    }

    public function AddEmployee(AddEmployeeRequest $rq) {
        try {
            $response = $this->users->signup($rq->validated());
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($response);
    }


}
