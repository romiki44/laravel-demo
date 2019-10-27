<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Support\Facades\Mail;

class NotifyUsersAboutComment
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        Mail::to($event->comment->commentable->user)->queue(
            new CommentPostedMarkdown($event->comment)
        );

        NotifyUsersPostWasCommented::dispatch($event->comment);
    }
}
