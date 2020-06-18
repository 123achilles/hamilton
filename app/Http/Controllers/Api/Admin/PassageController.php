<?php


namespace App\Http\Controllers\Api\Admin;

use App\Services\Api\Admin\PassageService;
use Illuminate\Http\Request;

class PassageController extends BaseController
{
    /**
     * PassageController constructor.
     * @param PassageService $passageService
     */
    public function __construct(PassageService $passageService)
    {
        $this->baseService = $passageService;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        $passage = $this->baseService->store($request->all());
        if (!$passage) {
            return response()->json(['error' => "not created"]);
        }
        return response()->json($passage);
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
        $section = $this->baseService->update($id, $request->all());
        if (!$section) {
            return response()->json(['error' => "not updated"]);
        }
        return response()->json(['success' => "updated"]);
    }

}
