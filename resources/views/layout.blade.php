<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    {{-- <ul class="nav justify-content-center">
        <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('posts.index')}}">Blog Posts</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('posts.create')}}">Add Blog Posts</a></li>
    </ul> --}}
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Laravel Blog</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="{{ route('home') }}">Home</a>
            <a class="p-2 text-dark" href="{{ route('contact') }}">Contact</a>
            <a class="p-2 text-dark" href="{{ route('posts.index') }}">Blog Posts</a>
            <a class="p-2 text-dark" href="{{ route('posts.create') }}">Add New</a>

            @guest
                @if(Route::has('register'))
                    <a class="p-2 text-dark" href="{{ route('register') }}">Register</a>
                @endif
                <a class="p-2 text-dark" href="{{ route('login') }}">Login</a>
            @else
                <a class="p-2 text-dark"
                    href="{{ route('user.show', ['user'=>Auth::user()->id]) }}">Profile</a>
                <a class="p-2 text-dark"
                    href="{{ route('user.edit', ['user'=>Auth::user()->id]) }}">Edit profile</a>
                <a class="p-2 text-dark" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Logout ({{Auth::user()->name}})
                </a>
                <form id="logout-form" action="{{route('logout')}}" method="post" style="display:none">
                    @csrf
                </form>
            @endguest
        </nav>
    </div>

    <div class="container">
    @if (session()->has('status'))
        <p style="color: green">
            {{session()->get('status')}}
        </p>
    @endif

    @yield('content')
    </div>

    <script src="{{mix('js/app.js')}}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
</body>
</html>
