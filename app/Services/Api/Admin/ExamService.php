<?php


namespace App\Services\Api\Admin;


use App\Models\Exam;

class ExamService extends BaseService
{
    /**
     * ExamService constructor.
     * @param Exam $exam
     */
    public function __construct(Exam $exam)
    {
        $this->set_model($exam);
    }

    /**
     * @var array
     */
    public $findColumns = ['id', 'title'];



    /**
     * @return mixed
     */
    public function index()
    {
        return Exam::paginate(10,['title']);
    }

//    /**
//     * @param $data
//     * @return mixed
//     */
//    public function store($data)
//    {
//        return Exam::create($data);
//    }
//
//    public function update($id, $data)
//    {
//        $exam =  Exam::find($id,['id', 'title']);
//        if (!$exam){
//            return false;
//        }
//        return $exam->update([$data]);
//    }
//
//    /**
//     * @param $id
//     * @return int
//     */
//    public function delete($id)
//    {
//        return Exam::destroy($id);
//    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return Exam::with('sections:id,exam_id,title')->find($id, ['id', 'title']);
    }
}
