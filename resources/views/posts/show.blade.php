@extends('layout')

@section('content')
<h1>{{$post->id}} {{$post->title}}</h1>
<p>Added:{{$post->created_at->diffForHumans()}}</p>

<h4>Comments</h4>
@forelse($post->comments as $comment)
    <p>
        {{$comment->content}}
    </p>
    <p class="text-muted">
        added {{$comment->created_at->diffForHumans()}}
    </p>
@empty
    <p>No comments yet!</p>
@endforelse

@endsection
