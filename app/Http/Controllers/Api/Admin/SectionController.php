<?php


namespace App\Http\Controllers\Api\Admin;


use App\Services\Api\Admin\SectionService;
use Illuminate\Http\Request;

class SectionController extends BaseController
{
    /**
     * SectionController constructor.
     * @param SectionService $sectionService
     */
    public function __construct(SectionService $sectionService)
    {
        $this->baseService = $sectionService;
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
            'time' => 'required|int',
            'directions' => 'required',
        ]);

        $section = $this->baseService->store($request->all());

        if (!$section) {
            return response()->json(['error' => "not created"]);
        }
        return response()->json($section);
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
            'time' => 'required|int',
            'directions' => 'required',
        ]);
        $section = $this->baseService->update($id, $request->all());
        if (!$section) {
            return response()->json(['error' => "not updated"]);
        }
        return response()->json(['success' => "updated"]);
    }
}
