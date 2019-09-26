<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

        return view(
            'posts.index',
            ['posts'=>BlogPost::withCount('comments')->get()]
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
        return view('posts.show', ['post'=>BlogPost::findOrFail($id)]);
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
