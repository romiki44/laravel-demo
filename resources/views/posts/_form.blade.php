<div class="form-group">
    <label>Title</label>
    <input class="form-control" type="text" name="title" value="{{old('title', $post->title ?? null)}}">
</div>
<div class="form-group">
    <label>Content</label>
    <input class="form-control" type="text" name="content" value="{{old('content', $post->content ?? null)}}">
</div>

@if ($errors->any)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
