<?php


namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * @var
     */
    protected $baseService;

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $deleted = $this->baseService->delete($id);
        if (!$deleted) {
            return response()->json(["error" => "item not deleted"]);
        }
        return response()->json(["success" => "item deleted"]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = $this->baseService->find($id);
        if (!$item){
            return response()->json(['error' => "Item not found by id"]);
        }

        return response()->json($item);
    }

}
