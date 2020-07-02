<?php


namespace App\Services\Api;


use App\Models\Answer;
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
     * @param $id
     * @return mixed
     */
    public function getExam($id)
    {
        $exam = $this->baseModel->with('sections.passages.questions', 'sections.directions')->find($id, ['id', 'title']);
        return $exam;
    }

    /**
     * @return mixed
     */
    public function getAllExams()
    {
        $exams = $this->baseModel->paginate(25, ['id', 'title']);
        return $exams;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function searchExamsByTitle($data)
    {
        $exams = collect([]);
        if (!empty($data)){
            $exams = $this->baseModel->where('title', 'LIKE', "%{$data['search']}%")->paginate(25, ['id', 'title']);
        }
        return $exams;
    }
}
