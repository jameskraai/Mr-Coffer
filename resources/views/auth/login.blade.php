<!-- resources/views/auth/login.blade.php -->
@extends('master')

@section('content')
    <form method="POST" action="{!! url('/login') !!}">
        {!! csrf_field() !!}
        <label for="email">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" id="email">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <label for="remember-me">Remember Me</label>
        <input type="checkbox" name="remember" id="remember-me">

        <button type="submit">Login</button>
        <a href="{!! route('register') !!}">Register</a>
    </form>
@endsection