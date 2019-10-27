<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;

use Illuminate\Contracts\Queue\ShouldQueue;

class PostCommentController extends Controller implements ShouldQueue
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post)
    {
        // dump(is_array($post->comments));
        // dump(get_class($post->comments));
        // die;
        return $post->comments()->with('user')->get();
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $comment=$post->comments()->create([
            'content'=>$request->input('content'),
            'user_id'=>$request->user()->id
        ]);

        event(new CommentPosted($comment));

        return redirect()->back()->withStatus('Comment was added!');
    }
}
