<?php

namespace App\Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Http\Requests\AddProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private $products;

    /**
     * ProductController constructor.
     * @param $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Product::welcome");
    }

    public function getAll()
    {
        $result = $this->products->getAll();

        return response()->json($result);
    }


    public function getById($id)
    {

        try {
            $result = $this->products->getById($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }

    public function add(AddProductRequest $rq)
    {

        try {
            $result = $this->products->add($rq->validated());
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }

    public function delete($id)
    {

        try {
            $result = $this->products->remove($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }


    public function update(AddProductRequest $rq, $id) {
        try {
            $result = $this->products->change($rq->validated(), $id);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }


    public function getCenterProducts($id) {
        try {
            $result = $this->products->getCenterProducts($id);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }


}
