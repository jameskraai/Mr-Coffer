@extends('master')
<h1>Create a new Account</h1>
@if(count($errors) > 0)
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form action="{!! route('account.store') !!}" method="post">
    {{ csrf_field()  }}
    <label for="name">Name: </label>
    <input type="text" name="name" id="name">
    <label for="number">Number: </label>
    <input type="text" name="number" id="number">
    <label for="account-type">Account Type: </label>
    <select id="account-type" name="account-type">
        <option selected disabled>select</option>
        @foreach($accountTypes as $accountType)
            <option value="{{ $accountType->id }}">{{ $accountType->name }}</option>
        @endforeach
    </select>
    <label for="bank">Bank: </label>
    <select id="bank" name="bank">
        <option selected disabled>select</option>
        @foreach($banks as $bank)
            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
        @endforeach
    </select>
    <input type="submit" value="Save" name="save">
</form>