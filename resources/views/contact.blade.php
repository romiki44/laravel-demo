@extends('layout')

@section('content')
<h1>Contacts</h1>
<p>Hello, this is contact!</p>

@can('home.secret')
    <p>
        <a href="{{route('secret')}}">Go to special contact details</a>
    </p>
@endcan

@endsection

