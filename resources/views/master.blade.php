<!doctype html>
<html>
    <head>
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
