<!-- resources/views/auth/login.blade.php -->
@extends('master')

@section('content')
    <form method="POST" action="{!! url('/login') !!}" id="login">
        {!! csrf_field() !!}
        <h1>Sign In</h1>

        <label for="email">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" id="email">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <label for="remember-me">
            <input type="checkbox" name="remember" id="remember-me">
            Stay signed in
        </label>

        <input type="submit" value="Sign In" />
        <a href="{!! route('register') !!}" id="register">Register</a>
    </form>
@endsection