<?php

namespace App\Repositories;

use App\Modules\Admin\Models\Admin;
use App\Modules\Center\Models\Center;
use App\Modules\Documentation\Models\Documentation;
use App\Modules\Product\Models\Product;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class ProductRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    public function getAll()
    {
        $offset = pager()['offset'];
        $limit = pager()['limit'];
        $product = Product::with(['center'])->offset($offset)->limit($limit)->get()->map(function($prod, $_) {
            $prod->desc = Str::substr($prod->desc, 0, 25) . '...';
            $prod->desc_ar = Str::substr($prod->desc_ar, 0, 25) . '...';
            return $prod;
        });

        return $product;
    }


    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws ErrorException
     */
    public function getProduct($id) {
        try {
            $product = Product::with(['center'])->findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Product not found', Response::HTTP_NOT_FOUND);
        }

        return $product;
    }


    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     * @throws ErrorException
     */
    public function getCenterProducts($id) {
        $offset = pager()['offset'];
        $limit = pager()['limit'];
        try {
            Center::findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Center not found', Response::HTTP_NOT_FOUND);
        }

        $products = Product::whereCenterId($id)->offset($offset)->limit($limit)->get()->map(function($prod, $_) {
            $prod->desc = Str::substr($prod->desc, 0, 25) . '...';
            $prod->desc_ar = Str::substr($prod->desc_ar, 0, 25) . '...';
            return $prod;
        });



        return $products;
    }


    /**
     * @param $rq
     * @return Product
     * @throws ErrorException
     */
    public function add($rq) {
        $product = new Product();

        $admin = Admin::whereUserId(Auth::id())->get()->first();

        $center = Center::find($rq['center_id']);

        unset($rq['center_id']);

        if (!$admin->hasCenter($center->id))
            throw new ErrorException('You\'r not the center owner', Response::HTTP_UNAUTHORIZED);


        if (isset($rq['image'])) {
            $photo = $rq['image'];
            $rq['image'] = saveFile($photo, 'products');
        }


        foreach ($rq as $key => $val) {
            $product->$key = $val;
        }

        $product->center()->associate($center);

        $product->save();

        return $product;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws ErrorException
     */
    public function getById($id)
    {
        try {
            $product = Product::with(['center'])->findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Product not found', Response::HTTP_NOT_FOUND);
        }

        return $product;
    }

    /**
     * @param $id
     * @return array
     * @throws ErrorException
     */
    public function remove($id)
    {
        try {
            $prod = Product::findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Product not found', Response::HTTP_NOT_FOUND);
        }

        deleteFile($prod->image);
        $prod->delete();

        return ['message' => 'Product deleted successfully'];
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
            $product = Product::findOrFail($id);
        } catch (\Throwable $e) {
            throw new ErrorException('Product not found', Response::HTTP_NOT_FOUND);
        }

        $admin = Admin::whereUserId(Auth::id())->get()->first();

        $center = Center::find($rq['center_id']);

        unset($rq['center_id']);

        if (!$admin->hasCenter($center->id))
            throw new ErrorException('You\'r not the center owner', Response::HTTP_UNAUTHORIZED);


        if (isset($rq['image'])) {
            $photo = $rq['image'];
            $rq['image'] = saveFile($photo, 'products');
        }


        foreach ($rq as $key => $val) {
            $product->$key = $val;
        }

        $product->save();

        return $product;
    }


}
