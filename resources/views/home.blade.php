@extends('layout')

@section('content')
<h1>{{__('messages.welcome')}}</h1>
<h1>@lang('messages.welcome')</h1>

<p>{{__('messages.example_with_value', ['name'=>'John'])}}</p>

<p>{{trans_choice('messages.plural',0)}}</p>
<p>{{trans_choice('messages.plural',1)}}</p>
<p>{{trans_choice('messages.plural',3)}}</p>
<p>{{trans_choice('messages.plural',5)}}</p>
<p>{{trans_choice('messages.plural',10)}}</p>

<h1>Using JSON: {{__('Welcome to Laravel!')}}</h1>
<p>{{__('Hello :name', ['name'=>'Roman'])}}</p>

<p>This is main page</p>
@endsection
