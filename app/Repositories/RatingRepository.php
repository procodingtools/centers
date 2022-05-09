<?php

namespace App\Repositories;

use App\Modules\Admin\Models\Admin;
use App\Modules\Client\Models\Client;
use App\Modules\Rating\Models\Rating;
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
class RatingRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Rating::class;
    }


    public function add($rq) {
        $rating = new Rating();
        $rq['admin_id'] = $rq['employee_id'];
        unset($rq['employee_id']);

        foreach ($rq as $key => $val) {
            $rating->$key = $val;
        }

        $rating->client_id = Client::whereUserId(Auth::id())->get()->first()->id;

        $rating->save();

        return $rating;
    }


    public function getAdmin($id) {
        $ratings = Rating::whereAdminId($id)->get();
        $rating = new \stdClass();
        $rating->rating = 0.0;
        foreach ($ratings as $r) {
            $rating->rating += $r->rating;
        }

        $rating->rating = $rating->rating / $ratings->count();
        $rating->ratings = $ratings;
        return $rating;
    }

    public function getCenter($id) {
        $ratings = Rating::whereCenterId($id)->get();
        $rating = new \stdClass();
        $rating->rating = 0.0;
        foreach ($ratings as $r) {
            $rating->rating += $r->rating;
        }

        $rating->rating = $rating->rating / $ratings->count();
        $rating->ratings = $ratings;
        return $rating;
    }

}
