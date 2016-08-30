<!doctype html>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="app.css">
    </head>
    <body>
        <header>
            <a id="logout" href="{!! route('logout') !!}">Logout</a>
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            {{-- Footer Content --}}
        </footer>
    </body>
</html>
