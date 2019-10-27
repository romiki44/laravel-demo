<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Contracts\CounterContract;
use App\Events\BlogPostPosted;
use App\Http\Requests\StorePost;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

//use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private $counter;

    public function __construct(CounterContract $counter)
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
        //$this->middleware('locale');
        $this->counter=$counter;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'posts.index',
            [
                'posts'=>BlogPost::latestWithRelations()->get(),
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

        //$counter=resolve(Counter::class);

        return view('posts.show', [
            'post'=>BlogPost::with('comments')->with('tags')->with('user')->findOrFail($id),
            //'counter'=>$counter->increment("blog-post-{$id}-counter", ['blog-post']),
            'counter'=>$this->counter->increment("blog-post-{$id}-counter", ['blog-post'])
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

        if($request->hasFile('thumbnail')) {
            $path=$request->file('thumbnail')->store('thumbnails');
            $blogPost->image()->save(
                Image::make(['path'=>$path])
            );
        }

        event(new BlogPostPosted($blogPost));

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

        if($request->hasFile('thumbnail')) {
            $path=$request->file('thumbnail')->store('thumbnails');

            if($post->image) {
                Storage::delete($post->image->path);
                $post->image->path=$path;
                $post->image->save();
            }
            else {
                $post->image()->save(
                    Image::make(['path'=>$path])
                );
            }
        }


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
