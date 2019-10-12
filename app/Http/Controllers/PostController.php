<?php

namespace App\Http\Controllers;

use App\User;
use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(BlogPost::all());
        // DB::connection()->enableQueryLog();

        // $posts=BlogPost::with('comments')->get();

        // foreach($posts as $post) {
        //     foreach($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        $mostCommented=Cache::remember('blog-post-commented', now()->addSecond(10), function () {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive=Cache::remember('users-most-active', now()->addSecond(10), function () {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth=Cache::remember('users-most-active-last-most', now()->addSecond(10), function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        return view(
            'posts.index',
            [
                'posts'=>BlogPost::latest()->withCount('comments')->with('user')->get(),
                'mostCommented'=>$mostCommented,
                'mostActive'=>$mostActive,
                'mostActiveLastMonth'=>$mostActiveLastMonth
            ]
        );
    }

   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('posts.show', [
        //     'post'=>BlogPost::with(['comments'=>function($query){
        //         $query->latest();
        //     }])->findOrFail($id)
        // ]);

        $sessionId=session()->getId();
        $counterKey="blog-post-{$id}-counter";
        $usersKey="blog-post-{$id}-users";

        $users=Cache::get($usersKey, []);
        $usersUpdate=[];
        $difference=0;
        $now=now();

        $counter=0;

        foreach($users as $session=>$lastVisit) {
            if($now->diffInMinutes($lastVisit)>=1) {
                $difference--;
            } else {
                $usersUpdate[$session]=$lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users) ||
            $now->diffInMinutes($lastVisit)>=1) {
            $difference++;
        }

        $usersUpdate[$sessionId]=$now;
        Cache::forever($usersKey, $usersUpdate);

        if(!Cache::has($counterKey)) {
            Cache::forever($counterKey, 1);
        } else {
            Cache::increment($counterKey, $difference);
        }

        $counter=Cache::get($counterKey);

        return view('posts.show', [
            'post'=>BlogPost::with('comments')->findOrFail($id),
            'counter'=>$counter
        ]);
    }

    public function create()
    {
        //nefungje, preco?
        //$this->authorize('create');
        //$this->authorize('posts.create');

        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData=$request->validated();
        $validatedData['user_id']=$request->user()->id;

        $blogPost=BlogPost::create($validatedData);

        /*$blogPost=new BlogPost();
        $blogPost->title=$request->input('title');
        $blogPost->content=$request->input('content');
        $blogPost->save();*/

        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.index');
    }

    public function edit($id)
    {
        $post=BlogPost::findOrFail($id);

        /*if(Gate::denies('update-post', $post)) {
            abort(403, "You can't edit this blog post!");
        }*/
        $this->authorize($post);
        //$this->authorize('update-post', $post);

        return view('posts.edit', ['post'=>$post]);
    }

    public function update(StorePost $request, $id)
    {
        $validatedData=$request->validated();

        $post=BlogPost::findOrFail($id);

        /*if(Gate::denies('update-post', $post)) {
            abort(403, "You can't edit this blog post!");
        }*/
        $this->authorize($post);
        //$this->authorize('posts.update', $post);

        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'Blog post was updated!');

        return redirect()->route('posts.index');
    }

    public function destroy(Request $request, $id)
    {
        $post=BlogPost::findOrFail($id);

        /*if(Gate::denies('delete-post', $post)) {
            abort(403, "You can't delete this blog post!");
        }*/
        $this->authorize($post);
        //$this->authorize('posts.delete', $post);

        $post->delete();
        //BlogPost::destroy($id);

        $request->session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }
}
