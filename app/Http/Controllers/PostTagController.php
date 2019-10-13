<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function index($tag)
    {
        $tag=Tag::findOrFail($tag);

        return view('posts.index', [
            //'posts'=>$tag->blogPosts //vraj menje query...ale u mna to iste
             'posts'=>$tag->blogPosts()->latestWithRelations()->get()
            ]);
    }
}
