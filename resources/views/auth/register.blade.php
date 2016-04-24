<!-- resources/views/auth/register.blade.php -->

<form method="POST" action="/register">
    {!! csrf_field() !!}

    <label for="name">Name</label>
    <input type="text" name="name" value="{{ old('name') }}" id="name">

    <label for="email">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" id="email">

    <label for="password">Password</label>
    <input type="password" name="password" id="password">

    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation">

    <button type="submit">Register</button>
    <a href="{!! route('login') !!}">Back</a>
</form>