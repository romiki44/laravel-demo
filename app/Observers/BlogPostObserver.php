<?php

namespace App\Observers;

use App\BlogPost;

class BlogPostObserver
{
    public function updating(BlogPost $blogPost)
    {

    }

    public function deleting(BlogPost $blogPost)
    {
        //dd("deleting...");
        $blogPost->comments()->delete();
    }

    public function restoring(BlogPost $blogPost)
    {
        $blogPost->comments()->restore();
    }

}
