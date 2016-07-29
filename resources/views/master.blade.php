<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="app.css">
    </head>
    <body>
        <header>
            <a href="{!! route('logout') !!}">Logout</a>
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            <small>Mr Coffer</small>
        </footer>
    </body>
</html>
