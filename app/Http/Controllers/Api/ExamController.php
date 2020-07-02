<?php


namespace App\Http\Controllers\Api;


use App\Services\Api\ExamService;

/**
 * Class ExamController
 * @package App\Http\Controllers\Api
 */
class ExamController extends BaseController
{

    /**
     * ExamController constructor.
     * @param ExamService $examService
     */
    public function __construct(ExamService $examService)
    {
        $this->baseService = $examService;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExam($id)
    {
        $exam = $this->baseService->getExam($id);
        if (!$exam) {
            return response()->json(['status' => 404, 'error' => 'exam not found']);
        }
        return response()->json(['status' => 200, 'data' => $exam]);
    }
}
