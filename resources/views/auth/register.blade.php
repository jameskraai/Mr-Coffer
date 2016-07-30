{{--
| Registration Form
| This view is the User registration form.
|
--}}
{{-- resources/views/auth/register.blade.php --}}
@extends('auth.main')

{{-- Set where this form should route to. --}}
@section('form_action')
    {!! url('/register') !!}
@endsection

@section('authentication_form')
    {!! csrf_field() !!}
    <h1>Pocket Advisor</h1>

    <label for="name">Name</label>
    <input type="text" name="name" value="{{ old('name') }}" id="name">

    <label for="email">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" id="email">

    <label for="password">Password</label>
    <input type="password" name="password" id="password">

    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation">

    <input type="submit" value="Register" />
    <a href="{!! route('login') !!}">Cancel</a>
@endsection