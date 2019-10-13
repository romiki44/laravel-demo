<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\BlogPost;
use App\User;

class ActivityComposer
{
    public function compose(View $view)
    {

        $mostCommented=Cache::remember('blog-post-commented', now()->addSecond(10), function () {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive=Cache::remember('users-most-active', now()->addSecond(10), function () {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth=Cache::remember('users-most-active-last-most', now()->addSecond(10), function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('mostCommented',$mostCommented);
        $view->with('mostActive',$mostActive);
        $view->with('mostActiveLastMonth',$mostActiveLastMonth);
    }
}
