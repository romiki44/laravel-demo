@extends('layout')
@section('content')
    <form method="post" action={{route('login')}}>
        @csrf
        <div class="container col-md-6">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" value="{{old('email')}}" required
                class="form-control {{$errors->has('email') ? 'is-invalid'  : ''}}">
            @if($errors->has('email'))
                <span class="invalid-feedback"><strong>{{$errors->first('email')}}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" value="" required
                class="form-control {{$errors->has('password') ? 'is-invalid'  : ''}}">
            @if($errors->has('password'))
                <span class="invalid-feedback"><strong>{{$errors->first('password')}}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input"
                value="{{old('remember') ? 'checked' : ''}}">
                <label for="remember" class="form-check-label">Remember Me</label>
            </div>
        </div>


        <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
    </form>
@endsection
