<?php


namespace App\Services\Api\Admin;


use App\Models\Choice;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionService extends BaseService
{

    /**
     * QuestionService constructor.
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->set_model($question);
    }

    /**
     * @param $data
     * @return bool|mixed
     */
    public function store($data)
    {
        $questionData = $data['question'];
        unset($data['question']);

        $dataImage = $this->getDataImage($questionData, 'question_img', 'question');
        if (!empty($dataImage)) {
            $questionData['question_img'] = $dataImage['file_name'];
        }

        $question = parent::store($questionData);
        if (!$question) {
            return false;
        }

        $choiceData = $data['choice'];
        $cData = $this->choiceData($choiceData);
        $choices = $question->choices()->saveMany($cData);

        if (!$choices) {
            return false;
        }

        return $question;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        $questionData = $data['question'];
        unset($data['question']);

        $dataImage = $this->getDataImage($questionData, 'question_img', 'question');
        if (!empty($dataImage)) {
            $questionData['question_img'] = $dataImage['file_name'];
        }
        DB::beginTransaction();
        $question = parent::update($id, $questionData);
        if (!$question) {
            DB::rollBack();
            return false;
        }
        $question = $this->baseModel->with('choices')->find($id, $this->findColumns);//TODO nenc anel vor question erku angam chhanem
        $choiceData = $data['choice'];
        $cData = $this->choiceDataUpdate($choiceData);

        $choices = $question->choices;
        foreach($choices as $key => $ch){
            if (!$ch->update($cData[$key])){
                DB::rollBack();
                return false;
            }
        }

        DB::commit();
        return true;
    }

    /**
     * @param $choiceData
     * @return array
     */
    public function choiceDataUpdate($choiceData)
    {
        foreach ($choiceData as $i) {
            if (!empty($i['choice_img'])) {
                $imageName = $this->getDataImage($i, 'choice_img', 'question');
                $i['choice_img'] = $imageName['file_name'];
            }
            $d[] = $i;
        }
        return $d;
    }
    /**
     * @param $choiceData
     * @return array
     */
    public function choiceData($choiceData)
    {
        foreach ($choiceData as $i) {
            if (!empty($i['choice_img'])) {
                $imageName = $this->getDataImage($i, 'choice_img', 'question');
                $i['choice_img'] = $imageName['file_name'];
            }
            $d[] = new Choice($i);
        }

        return $d;
    }

    /**
     * @return mixed
     */
    public function getAllQuestions()
    {
        return $this->baseModel->count();
    }
}
