<?php


namespace App\Http\Controllers\Api\Admin;


use App\Models\Exam;
use App\Models\Passage;
use App\Models\Question;
use App\Models\Section;
use App\Services\Api\Admin\ExamService;
use Illuminate\Http\Request;

class ExamController extends BaseController
{

    public function __construct(ExamService $examService)
    {
        $this->baseService = $examService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items = $this->baseService->index();
        return response()->json($items);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $exam = $this->baseService->store($request->all());
        if (!$exam) {
            return response()->json(['error' => "not created"]);
        }
        return response()->json($exam);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $exam = $this->baseService->update($id, $request->all());
        if (!$exam) {
            return response()->json(['error' => "not updated"]);
        }
        return response()->json(['exam' => "updated"]);
    }



//    /**
//     * @param $id
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function delete($id)
//    {
//        $deleted = $this->baseService->delete($id);
//        if (!$deleted) {
//            return response()->json(["error" => "exam not deleted"]);
//        }
//        return response()->json(["success" => "exam deleted"]);
//    }
//
//    /**
//     * @param $id
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function show($id)
//    {
//        $exam = $this->baseService->find($id);
//        if (!$exam){
//            return response()->json(['error' => "exam not found by id"]);
//        }
//
//        return response()->json($exam);
//    }


}
