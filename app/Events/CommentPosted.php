<?php

namespace App\Events;

use App\Comment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;


class CommentPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment=$comment;
    }

}
