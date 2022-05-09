<?php

namespace App\Repositories;

use App\Modules\Admin\Models\Admin;
use App\Modules\Center\Models\Center;
use App\Modules\Documentation\Models\Documentation;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class DocumentationRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Documentation::class;
    }

    public function getAll()
    {
        $docs = Documentation::with(['center'])->get();

        return $docs;
    }


    public function add($rq) {
        $doc = new Documentation();

        $admin = Admin::whereUserId(Auth::id())->get()->first();

        $center = Center::find($rq['center_id']);

        unset($rq['center_id']);

        if (!$admin->hasCenter($center->id))
            throw new ErrorException('You\'r not the center owner', Response::HTTP_UNAUTHORIZED);


        if (isset($rq['image'])) {
            $photo = $rq['image'];
            $rq['image'] = saveFile($photo, 'docs');
        }


        foreach ($rq as $key => $val) {
            $doc->$key = $val;
        }

        $doc->center()->associate($center);

        $doc->save();

        return $doc;


    }

    /**
     * @param $rq
     * @param $id
     * @return mixed
     * @throws ErrorException
     */
    public function updateDoc($rq, $id) {
        if (isset($rq['image'])) {
            $image = $rq['image'];
            $rq['image'] = saveFile($image, 'docs');
        }
        try {
            $doc = Documentation::findOrFail($id);
        } catch(\Throwable $e) {
            throw new ErrorException('Documentation not found', Response::HTTP_NOT_FOUND);
        }

        foreach ($rq as $key => $val) {
            $doc->$key = $val;
        }

        $doc->save();

        return $doc;
    }

    public function remove($id)
    {
        try {
            $doc = Documentation::findOrFail($id);
        } catch (\Throwable $e) {
            return false;
        }

        deleteFile($doc->image);

        $doc->delete();

        return true;
    }

    public function centerDocs($id)
    {
        try {
            Center::findOrFail($id);
        } catch(\Throwable $e) {
            throw new ErrorException('Center not found', Response::HTTP_NOT_FOUND);
        }

        $docs = Documentation::whereCenterId($id)->get();

        return $docs;
    }


}
