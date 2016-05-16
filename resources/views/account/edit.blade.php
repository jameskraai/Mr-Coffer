@extends('master')
<h1>Edit Account</h1>
@if(count($errors) > 0)
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form action="/" method="post">
    {{ csrf_field() }}

    {{-- Name text field --}}
    <label for="name">Name: </label>
    <input type="text" name="name" id="name" value="{{ $account->name }}">

    {{-- Number text field --}}
    <label for="number">Number: </label>
    <input type="number" name="number" id="number" value="{{ $account->number }}">

    {{-- Type select menu --}}
    <label for="account-type">Account Type: </label>
    <select id="account-type" name="account-type">
        @foreach($accountTypes as $accountType)
            <option value="{{ $accountType->id }}" {{ $accountType->id === $account->type_id ? 'selected' : '' }}>
                {{ $accountType->name }}
            </option>
        @endforeach
    </select>

    {{-- Bank select menu --}}
    <label for="bank">Bank: </label>
    <select name="bank" id="bank">
        @foreach($banks as $bank)
            <option value="{{ $bank->id }}" {{ $bank->id === $account->bank_id ? 'selected' : '' }}>
                {{ $bank->name }}
            </option>
        @endforeach
    </select>
</form>
