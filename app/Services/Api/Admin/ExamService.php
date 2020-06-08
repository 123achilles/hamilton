<?php


namespace App\Services\Api\Admin;


use App\Models\Exam;

class ExamService extends BaseService
{

    /**
     * @return mixed
     */
    public function index()
    {
        return Exam::paginate(10,['title']);
    }

    public function store($data)
    {
        return Exam::create($data);
    }

    public function update($id, $data)
    {
        $exam =  Exam::find($id,['id', 'title']);
        if (!$exam){
            return false;
        }
        return $exam->update([$data]);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return Exam::destroy($id);
    }
}
