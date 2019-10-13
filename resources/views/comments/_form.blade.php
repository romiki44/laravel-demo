
<div class="mb-2 mt-2">
@auth
    <form method="POST" action="{{route('posts.comments.store', ['post'=>$post->id])}}">
        @csrf

        <div class="form-group">
            <textarea class="form-control" type="text" name="content"></textarea>
        </div>

        <button class="btn btn-primary" type="submit">Add comment</button>
    </form>
    @errors @enderrors
@else
    <a href="{{route('login')}}">Sign-in</a> to post comments!
@endauth
</div>
<hr/>
