<?php

namespace App\Repositories;

use App\Modules\Actuality\Models\Actuality;
use App\Modules\Admin\Models\Admin;
use App\Modules\Center\Models\Center;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class ActualityRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Actuality::class;
    }


    public function getAll()
    {
        $offset = pager()['offset'];
        $limit = pager()['limit'];

        $actualities = Actuality::with(['center'])->offset($offset)->limit($limit)->get();

        return $actualities;
    }


    /**
     * @param $rq
     * @return Actuality
     * @throws ErrorException
     */
    public function add($rq)
    {
        $actuality = new Actuality();

        $admin = Admin::whereUserId(Auth::id())->get()->first();

        $center = Center::find($rq['center_id']);

        unset($rq['center_id']);

        if (!$admin->hasCenter($center->id))
            throw new ErrorException('You\'r not the center owner', Response::HTTP_UNAUTHORIZED);

        if (isset($rq['image'])) {
            $photo = $rq['image'];
            $rq['image'] = saveFile($photo, 'actualities');
        }

        foreach ($rq as $key => $val) {
            $actuality->$key = $val;
        }

        $actuality->center()->associate($center);

        $actuality->save();

        return $actuality;
    }

    /**
     * @param $id
     * @return mixed
     * @throws ErrorException
     */
    public function getCenterActualities($id)
    {
        $offset = pager()['offset'];
        $limit = pager()['limit'];

        try {
            Center::findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Center not found', Response::HTTP_NOT_FOUND);
        }

        $actualities = Actuality::whereCenterId($id)->offset($offset)->limit($limit)->get();

        return $actualities;
    }

    /**
     * @param $rq
     * @param $id
     * @return mixed
     * @throws ErrorException
     */
    public function change($rq, $id)
    {
        try {
            $actuality = Actuality::findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Actuality not found', Response::HTTP_NOT_FOUND);
        }

        if (isset($rq['image'])) {
            $photo = $rq['image'];
            $rq['image'] = saveFile($photo, 'actualities');
        }

        foreach ($rq as $key => $val) {
            $actuality->$key = $val;
        }

        $actuality->save();

        return $actuality;
    }


    /**
     * @param $id
     * @return array
     * @throws ErrorException
     */
    public function remove($id) {
            $actuality = Actuality::find($id);
            if (is_null($actuality))
                throw new ErrorException('Actuality not found', Response::HTTP_NOT_FOUND);

        deleteFile($actuality->image);

        $actuality->delete();

        return ['message' => 'Actuality deleted successfully'];
    }

}
