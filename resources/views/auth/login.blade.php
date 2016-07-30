{{--
| Since the Login screen will not share a header or a footer in the same
| regard as the rest of the application I am opting to contain the
| entire HTML document in this file rather than extending
| the master layout.
|
--}}
{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE HTML>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="app.css">
    </head>
    <body>
        <main>
            <form method="POST" action="{!! url('/login') !!}" id="login">
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
                <a href="{!! route('register') !!}" id="register">Register</a>
            </form>
        </main>
    </body>
</html>