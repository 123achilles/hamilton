<?php

namespace App\Jobs;

use App\Mail\ConfirmUserMail;
use App\Mail\SendAnswerPdf;
use App\Models\Choice;
use App\Models\Question;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailAnswers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $answer;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = $this->savePDFFile();
        Mail::to('suro-11-7@mail.ru')->send(new SendAnswerPdf($fileName));
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function savePDFFile()
    {
        $answerText = [];
        $pdf = App::make('dompdf.wrapper');
        $userId = auth('api')->id();
        $user = User::find($userId, ['email', 'name']);
        if (!$user){
            Log::error('user not found this id', $userId);
        }

        foreach ($this->answer as $it){
            if ($it['answer']){
                $answerText[$it['question_id']] = $it['answer'];
            }
        };
        $choice_ids = collect($this->answer)->pluck('choice_id')->filter()->toArray();
        $choices = Choice::with('question:id,question,question_img')
            ->whereIn('id', $choice_ids)
            ->get(['id','question_id', 'choice_img', 'title'])->groupBy('question_id')->toArray();

        $i = 0;
        foreach ($answerText as $question_id => $answer){
            $questions[$i] = Question::find($question_id, ['question', 'question_img'])->toArray();
            $questions[$i]['answer'] = $answer;
            $i++;
        }
//        dd($choices, $questions);
//        die();
        $html = view('answers',compact('choices', 'questions', 'user'))->render();

//        dd($this->answer,222);
        $pdf->loadHTML($html);
        $filename =  $user['name'].'_'.date('l jS \of F Y').'.pdf';
        $pdf->save($filename);
        return $filename;
//        dd($pdf->save($filename));

    }
}
