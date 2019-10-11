@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
    @forelse ($posts as $post)
        <p>
            <h3>
                @if($post->trashed())
                    <del>
                @endif
                    <a href="{{route('posts.show', ['post'=>$post->id])}}"
                        class="{{$post->trashed() ? 'text-muted' : ''}}">
                    {{$post->title}}
                </a>
                @if($post->trashed())
                    </del>
                @endif
            </h3>

            @updated(['date'=>$post->created_at, 'name'=>$post->user->name])
            @endupdated

            @if($post->comments_count)
                <p>{{$post->comments_count}} comments</p>
            @else
                <p>No comments yet!</p>
            @endif

            @can('update', $post)
                <a class="btn btn-primary" href="{{route('posts.edit', ['post'=>$post->id])}}">Edit</a>
            @endcan

            @if(!$post->trashed())
                @can('delete', $post)
                    <form method="POST" class="fm-inline"
                        action="{{route('posts.destroy', ['post'=>$post->id])}}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-primary"/>
                    </form>
                @endcan
            @endif
        </p>
    @empty
        <p>No blog post yet!</p>
    @endforelse
    </div>
    <div class="col-4">
        <div class="container">
            <div class="row">
                {{-- <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most commented</h5>
                        <h6 class="card-subtitle mb-2 text-muted">What people curently talking about</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostCommented as $post)
                            <li class="list-group-item">
                            <a href="{{route('posts.show', ['post'=>$post->id])}}">{{$post->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}

                @card(['title'=>'Most commented'])
                    @slot('subtitle')
                        What people curently talking about
                    @endslot
                    @slot('items')
                        @foreach ($mostCommented as $post)
                            <li class="list-group-item">
                            <a href="{{route('posts.show', ['post'=>$post->id])}}">{{$post->title}}</a>
                            </li>
                        @endforeach
                    @endslot
                @endcard
            </div>
            <div class="row mt-4">
                {{-- <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most active</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Users with most posts written</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActive as $user)
                            <li class="list-group-item">
                                {{$user->name}}
                            </li>
                        @endforeach
                    </ul>
                </div> --}}
                @card(['title'=>'Most Active', 'subtitle'=>'Users with most posts written'])
                    @slot('items', collect($mostActive)->pluck('name'))
                @endcard
            </div>

            <div class="row mt-4">
                {{-- <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most active last month</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Users with most posts written last month</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActiveLastMonth as $user)
                            <li class="list-group-item">
                                {{$user->name}}
                            </li>
                        @endforeach
                    </ul>
                </div> --}}

                @card(['title'=>'Most active last month', 'subtitle'=>'Users with most posts written last month'])
                    @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                @endcard
            </div>
        </div>
    </div>
</div>
@endsection
