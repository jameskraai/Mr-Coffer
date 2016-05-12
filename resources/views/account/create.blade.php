@extends('master')
<h1>Create a new Account</h1>
<form action="{!! route('account.store') !!}" method="post">
    {{ csrf_field()  }}
    <label for="number">Number</label>
    <input type="text" name="number" id="number">
    <input type="submit" value="Save">
</form>