@extends('master')
<h1>{{  $account->name }}</h1>
<table>
    <thead>
        <tr><th>Transactions</th></tr>
        <tr>
            <th>Payee</th>
            <th>Memo</th>
            <th>Amount</th>
            <th>Category</th>
            <th>Status</th>
            <th>Updated</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        @foreach($account->transactions as $transaction)
            <tr>
                {{-- Payee --}}
                <td>{{ $transaction->payee->name }}</td>

                {{-- Memo --}}
                <td>{{ $transaction->memo }}</td>
                {{-- Amount --}}
                <td>{{ $transaction->amount }}</td>
                {{-- Category --}}
                <td>{{ $transaction->category->name }}</td>
                {{-- Status --}}
                <td>{{ $transaction->status->name }}</td>
                {{-- Updated --}}
                <td>{{ $transaction->updated_at }}</td>

                {{-- Created --}}
                <td>{{ $transaction->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
