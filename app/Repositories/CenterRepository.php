<?php

namespace App\Repositories;

use App\Modules\Actuality\Models\Actuality;
use App\Modules\Admin\Models\Admin;
use App\Modules\Center\Models\Center;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class CenterRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Center::class;
    }


    public function getMine() {
        $center = Admin::with(['centers'])->whereUserId(Auth::id())->get()->first()->centers;

        return $center;
    }


    public function add($rq) {
        $center = new Center();

        if (isset($rq['image'])) {
            $photo = $rq['image'];
            $rq['image'] = saveFile($photo, 'centers');
        }

        foreach ($rq as $key => $val) {
            $center->$key = $val;
        }

        $center->save();

        $center->admins()->save(Admin::whereUserId(Auth::id())->get()->first());

        return $center;
    }

    public function getAll()
    {
        $offset = pager()['offset'];
        $limit = pager()['limit'];
        $centers = Center::limit($limit)->offset($offset)->get();

        return $centers;
    }


    public function remove($id) {
        try {
            $center = Center::findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Center not found', Response::HTTP_NOT_FOUND);
        }

        deleteFile($center->image);

        $center->delete();

        return ['message' => 'Center deleted successfully'];
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
            $center = Center::findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Center not found', Response::HTTP_NOT_FOUND);
        }

        if (isset($rq['image'])) {
            $photo = $rq['image'];
            $rq['image'] = saveFile($photo, 'centers');
        }

        foreach ($rq as $key => $val) {
            $center->$key = $val;
        }

        $center->save();

        $center->admins()->save(Admin::whereUserId(Auth::id())->get()->first());

        return $center;
    }

}
