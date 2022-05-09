<?php

namespace App\Modules\Documentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Documentation\Http\Requests\AddDocumentationRequest;
use App\Repositories\DocumentationRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentationController extends Controller
{

    private $documentations;

    /**
     * DocumentationController constructor.
     * @param $documentations
     */
    public function __construct(DocumentationRepository $documentations)
    {
        $this->documentations = $documentations;
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Documentation::welcome");
    }


    public function getAll()
    {
        $result = $this->documentations->getAll();

        return response()->json($result);
    }


    public function add(AddDocumentationRequest $rq)
    {
        try {
            $result = $this->documentations->add($rq->validated());
        } catch (\Throwable $e) {
            response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }

    public function update(AddDocumentationRequest $rq, $id)
    {
        try {
            $result = $this->documentations->updateDoc($rq->validated(), $id);
        } catch (\Throwable $e) {
            response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }


    public function delete($id)
    {
        $result = $this->documentations->remove($id);

        return response()->json(['message' => $result ? 'Documentation deleted successfully' : 'Documentation not found'], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }


    public function getCenterDocumentations($id) {
        try {
            $result = $this->documentations->centerDocs($id);
        } catch (\Throwable $e) {
            response()->json(['message' => $e->getMessage()], intval($e->getCode()));
        }

        return response()->json($result);
    }


}