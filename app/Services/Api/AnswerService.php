<?php


namespace App\Services\Api;


use App\Jobs\SendEmailAnswers;
use App\Models\Answer;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class AnswerService extends BaseService
{
    /**
     * AnswerService constructor.
     * @param Answer $answer
     */
    public function __construct(Answer $answer)
    {
        $this->set_model($answer);
    }

    public function store($data)
    {
//        $pdf = App::make('dompdf.wrapper');
//
//        $k = view('welcome')->render();
//
//        $pdf->loadHTML($k);
//
//        dd($pdf->save('poxos4.pdf'));die(1);
//
//        dd(11);

        $data = [
            'question_4' => 7,

            'question_5' => [
                16,
                14
            ],
            'question_7' => 18,
            'question_10' => 11,
            'question_12' => [
                21,
                22
            ],
            'question_15_text' => 'sfsdfsdfdsfsdf',
            'question_8_text' => 'fdsff'
        ];
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $value) {
                    $ans[] = [
                        'user_id' => auth('api')->id(),
                        'question_id' => explode('_', $key)[1],
                        'choice_id' => $value,
                        'answer' => Null,
                    ];
                }
            } else {
                $columnNameSave = 'choice_id';
                $columnNameNull = 'answer';
                if (!empty(explode('_', $key)[2])) {
                    $columnNameSave = 'answer';
                    $columnNameNull = 'choice_id';
                }

                $ans[] = [
                    'user_id' => auth('api')->id(),
                    'question_id' => explode('_', $key)[1],
                    "$columnNameSave" => $item,
                    "$columnNameNull" => Null,
                ];
            }
        }


        dispatch(new SendEmailAnswers($ans));die();
        $inserted = $this->baseModel->insert($ans);
        return $inserted;
    }
}
