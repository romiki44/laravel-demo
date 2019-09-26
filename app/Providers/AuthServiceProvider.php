<?php

namespace App\Providers;

use Illuminate\Auth\Access\Gate as IlluminateGate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\BlogPost'=>'App\Policies\BlogPostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('home.secret', function($user){
            return $user->is_admin;
        });

        // posts.create, posts.update, posts.delete, posts.view
        //Gate::resource('posts', 'App\Policies\BlogPostPolicy');

        //Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        //Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');

        Gate::before(function ($user, $ability) {
            if($user->is_admin && in_array($ability, ['update', 'delete'])) {
                return true;
            }
        });

        /*Gate::define('update-post', function($user, $post) {
            return $user->id==$post->user_id;
        });

        Gate::define('delete-post', function($user, $post) {
            return $user->id==$post->user_id;
        });

        Gate::before(function ($user, $ability) {
            if($user->is_admin && in_array($ability, ['update-post'])) {
                return true;
            }
        });*/

        // Gate::after(function ($user, $ability, $result) {
        //     if($user->is_admin) {
        //         return true;
        //     }
        // });
    }
}
