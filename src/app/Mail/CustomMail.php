<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $text;

    public function __construct($subject, $text)
    {
        $this->subject = $subject;
        $this->text = $text;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->view('admin.custom_email')
            ->with('text', $this->text);
    }
}
