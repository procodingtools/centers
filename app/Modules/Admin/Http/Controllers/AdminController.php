<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{


    private $users;

    /**
     * AdminController constructor.
     * @param $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Admin::welcome");
    }

    public function getEmployees($id) {
        try {
            $result = $this->users->getCenterEmployees($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json($result);
    }
}
