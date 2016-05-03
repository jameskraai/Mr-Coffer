<!DOCTYPE HTML>
<html>
    <head>

    </head>
    <body>
        <main>
            <h1>Dashboard</h1>
            <h3>{{ $user->name }}</h3>
            <a href="{!! route('logout') !!}">Logout</a>
        </main>
    </body>
</html>
