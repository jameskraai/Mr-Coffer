<!DOCTYPE HTML>
<html>
    <head>

    </head>
    <body>
        <main>
            <h1>Dashboard</h1>
            <h3>{{ $user->name }}</h3>
            <a href="{!! route('logout') !!}">Logout</a>
            <table>
                <thead>
                    <tr><th>Accounts</th></tr>
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->accounts as $account)
                        <tr>
                            <td><a href="{!! route('account.show', [$account->id]) !!}">{{ $account->name }}</a></td>
                            <td>{{ $account->number }}</td>
                            <td><a href="{!! route('account.edit', [$account->id]) !!}">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </body>
</html>
