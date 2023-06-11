<?php

namespace App\Jobs;

use App\Mail\CommentNotification;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCommentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $comment;
    protected $commentUserEmail;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param  int  $commentId
     * @param  string  $commentUserEmail
     * @return void
     */
    public function __construct($commentId, $commentUserEmail,$data)
    {
        $this->comment = Comment::find($commentId);
        $this->commentUserEmail = $commentUserEmail;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $comment = $this->comment;
        $commentUserEmail = $this->commentUserEmail;
        $data = $this->data;

        Mail::to($commentUserEmail)->send(new CommentNotification($comment,$data));
    }
}