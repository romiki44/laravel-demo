<div class="container">
    <div class="row">
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
        @card(['title'=>'Most Active', 'subtitle'=>'Users with most posts written'])
            @slot('items', collect($mostActive)->pluck('name'))
        @endcard
    </div>

    <div class="row mt-4">
        @card(['title'=>'Most active last month', 'subtitle'=>'Users with most posts written last month'])
            @slot('items', collect($mostActiveLastMonth)->pluck('name'))
        @endcard
    </div>
</div>
