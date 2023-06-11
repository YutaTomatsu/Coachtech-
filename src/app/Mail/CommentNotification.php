<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $data;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Comment  $comment
     * @param  array  $data
     * @return void
     */
    public function __construct(\App\Models\Comment $comment, array $data)
    {
        $this->comment = $comment;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.comment_notification')
            ->subject('新しいコメントが届きました')
            ->with('data', $this->data);
    }
}
