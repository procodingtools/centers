<?php

namespace App\Repositories;

use App\Modules\Admin\Models\Admin;
use App\Modules\Center\Models\Center;
use App\Modules\Client\Models\Client;
use App\Modules\User\Models\User;
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
class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }



    public function login($rq) {
        if (isset($rq['email'])) {
            if (Auth::attempt($rq))
                $user = User::with(['admin', 'client'])->whereEmail($rq['email'])->get()->first();
            else
                return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        } else {
            $user = User::with(['admin', 'client'])->whereSocialUuid($rq['social_uuid'])->get()->first();
            if (is_null($user))
                return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $response = new \stdClass();
        $scope = $user->admin ? $user->admin->role : 'client';
        $user->code = encode($user->id, 'uuid');
        $response->token = $user->createToken('token', [$scope])->accessToken;
        $response->user = $user;

        return response()->json($response);
    }


    /**
     * @param $rq
     * @throws ErrorException
     */
    public function signup($rq) {
        if (isset($rq['email'])) {
            $user = User::whereEmail($rq['email'])->get()->first();
            if (!is_null($user)) {
                throw new ErrorException('User Already Exists', Response::HTTP_CONFLICT);
            }
        }

        if (isset($rq['role'])) {
            $role = $rq['role'];
            unset($rq['role']);
        } else $role = 'client';

        if ($role != 'client') {
            try {
                $center = Center::findOrFail($rq['center_id']);
                unset($rq['center_id']);
            } catch(\Throwable $e) {
                return new ErrorException('Center not found', Response::HTTP_NOT_FOUND);
            }
        }

        if ($role == 'client') {
            $gender = $rq['gender'] == 'male' ? 1 : 0;
            unset($rq['gender']);
        }

        if (isset($rq['password'])) {
            $passwd = bcrypt($rq['password']);
            unset($rq['password']);
        }

        $user = new User();
        foreach ($rq as $key => $val)
            $user->$key = $val;

        if (!is_null($passwd))
            $user->password = $passwd;

        $user->save();

        if ($role == 'client') {
            $client = new Client();
            $client->gender = $gender;
            $client->user()->associate($user);
            $client->save();
        } else {
            $admin = new Admin();
            $admin->role = $role;
            $admin->user()->associate($user);
            $admin->save();
            $admin->centers()->save($center);
        }


        $user = User::with(['admin', 'client'])->find($user->id);

        $response = new \stdClass();
        $response->token = $user->createToken('token', [$role])->accessToken;
        $response->user = $user;
        return $response;

    }


    /**
     * @param $centerId
     * @return array
     * @throws ErrorException
     */
    public function getCenterEmployees($id) {
        try {
            $center = Center::with(['admins'])->whereHas('admins', function($q) {
                $q->role = "employee";
            })->findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Center not found', Response::HTTP_NOT_FOUND);
        }


        return $center->admins;
    }





}
