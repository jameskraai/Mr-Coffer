<!DOCTYPE HTML>
<html>
    <head>

    </head>
    <body>
        <main>
            <h1>Dashboard</h1>
            <h3>{{ $user->name }}</h3>
            <a href="{!! route('logout') !!}">Logout</a>

            <section id="accounts">
                <h3>Accounts</h3>
                <ul>
                    @foreach($user->accounts as $account)
                        <li>{{ $account->number }}</li>
                    @endforeach
                </ul>
            </section>
        </main>
    </body>
</html>
