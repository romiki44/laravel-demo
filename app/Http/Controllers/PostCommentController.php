<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StoreComment;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $commment=$post->comments()->create([
            'content'=>$request->input('content'),
            'user_id'=>$request->user()->id
        ]);

        Mail::to($post->user)->send(
            //new CommentPosted($commment)
            new CommentPostedMarkdown($commment)
        );

        return redirect()->back()->withStatus('Comment was added!');
    }
}
