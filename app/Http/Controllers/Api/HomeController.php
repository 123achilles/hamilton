<?php


namespace App\Http\Controllers\Api;


use App\Services\Api\ExamService;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * HomeController constructor.
     * @param ExamService $examService
     */
    public function __construct(ExamService $examService)
    {
        $this->baseService = $examService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllExams(Request $request)
    {
        if (empty($request->all())){
            $exams = $this->baseService->getAllExams();
        }else{
            $exams = $this->baseService->searchExamsByTitle($request->only('search'));
        }

        if ($exams->isEmpty()){
            return response()->json(['status' => 404, 'error' => 'exam not found']);
        }

        return response()->json(['status' => 200, 'data' => $exams]);
    }

}
