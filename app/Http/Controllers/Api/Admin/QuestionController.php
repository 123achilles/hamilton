<?php


namespace App\Http\Controllers\Api\Admin;


use App\Services\Api\Admin\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
    /**
     * QuestionController constructor.
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {
        $this->baseService = $questionService;
    }

    public function store(Request $request)
    {
//        $this->validate($request, [
//            'title' => 'required'
//        ]);
        $question = $this->baseService->store($request->all());
        if (!$question) {
            return response()->json(['error' => "not created"]);
        }
        return response()->json($question);
    }

    public function update(Request $request, $id)
    {
//        $this->validate($request, [
//            'title' => 'required',
//            'time' => 'required|int',
//            'directions' => 'required',
//        ]);
        $question = $this->baseService->update($id, $request->all());
        if (!$question) {
            return response()->json(['error' => "not updated"]);
        }
        return response()->json(['success' => "updated"]);
    }
}
