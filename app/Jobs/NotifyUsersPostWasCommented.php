<?php

namespace App\Jobs;

use Mail;
use App\Comment;
use App\Mail\CommentPostedOnPostWatched;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;

class NotifyUsersPostWasCommented
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment=$comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now=now();
        User::thatHasCommentedOnPost($this->comment->commentable)
            ->get()
            ->filter(function (User $user) {
                return $user->id !== $this->comment->user_id;
            })->map(function (User $user) use($now) {
                Mail::to($user)->later(
                    $now->addSecond(10),
                    new CommentPostedOnPostWatched($this->comment, $user)
                );
            });
    }
}
