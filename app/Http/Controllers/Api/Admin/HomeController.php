<?php


namespace App\Http\Controllers\Api\Admin;


use App\Services\Api\Admin\ExamService;
use App\Services\Api\Admin\QuestionService;

class HomeController extends BaseController
{
    /**
     * @var ExamService
     */
    public $examService;
    /**
     * @var QuestionService
     */
    public $questionService;

    /**
     * HomeController constructor.
     * @param ExamService $examService
     * @param QuestionService $questionService
     */
    public function __construct(ExamService $examService, QuestionService $questionService)
    {
        $this->examService = $examService;
        $this->questionService = $questionService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $countExams = $this->examService->getAllExams();
        $countQuestions = $this->questionService->getAllQuestions();

        return response()->json(["status" => 200, "data"=>['exam_count' => $countExams, 'question_count' => $countQuestions]]);
    }

}
