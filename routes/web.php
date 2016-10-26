<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Auth::routes();
Route::get('/', 'HomeController@index')->middleware(['auth']);
Route::get('/account/create', 'Account\CreateController@create')->name('account.create');
Route::get('/account/{id}', 'Account\ShowController@show')->name('account.show');
Route::get('/account/{id}/edit', 'Account\EditController@edit')->name('account.edit');  