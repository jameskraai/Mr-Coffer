{{--
| Login Form
| This view is the Login Form that is displayed to a non authenticated User.
|
--}}
{{-- resources/views/auth/login.blade.php --}}
@extends('auth.main')

{{-- Fill in where this form will route to. --}}
@section('form_action')
    {!! url('/login') !!}
@endsection

@section('authentication_form')
    {!! csrf_field() !!}
    <h1>Pocket Advisor</h1>

    <label for="email">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" id="email">

    <label for="password">Password</label>
    <input type="password" name="password" id="password">

    <label for="remember-me">
        <input type="checkbox" name="remember" id="remember-me">
        Stay signed in
    </label>

    <input type="submit" value="Sign In" />
    <a href="{!! url('/register') !!}">Register</a>
@endsection