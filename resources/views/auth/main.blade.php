{{--
| Since the Authentication Forms will not share a header nor a footer in the same
| regard as the rest of the application; I am opting to contain the entire
| HTML document in this separate main file rather than extending
| the global master layout.
--}}
<!DOCTYPE HTML>
<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="app.css">
    </head>
    <body>
        <main>
            <form method="POST" action="@yield('form_action')" id="authentication">
                @yield('authentication_form')
            </form>
        </main>
    </body>
</html>