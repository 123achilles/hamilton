<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAnswerPdf extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = auth('api')->user();
        return $this->view('emails.sendAnswerPdf', [
            'name' => $user->name,
            'email' => $user->email,
        ])->attach(public_path($this->fileName), [
            'as' => $this->fileName,
            'mime' => 'application/pdf',
        ]);
    }
}

