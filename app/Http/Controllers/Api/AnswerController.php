<?php


namespace App\Http\Controllers\Api;


use App\Services\Api\AnswerService;
use Illuminate\Http\Request;

class AnswerController extends BaseController
{
    /**
     * AnswerController constructor.
     * @param AnswerService $answerService
     */
    public function __construct(AnswerService $answerService)
    {
        $this->baseService = $answerService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $inserted = $this->baseService->store($request->all());

        if (!$inserted){
            return response()->json(['status' => 500, 'message' => 'not inserted asnwers']);
        }
        return response()->json(['status' => 200, 'message' => 'inserted asnwers']);
    }
}
