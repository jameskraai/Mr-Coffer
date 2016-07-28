<?php

use Illuminate\Routing\Router;

/**
 * Declare all Http Routes within this callback function. This function will be invoked with
 * a Router instance injected into it at the RouteServiceProvider class.
 *
 * @var Router $route
 *
 * @see \MrCoffer\Providers\RouteServiceProvider
 * @return void
 */

/**
 * Dashboard
 * When the User is logged in they will be routed to the dashboard. This is where
 * they can manage all of their Transactions, Accounts, etc.
 */
$route->get('/', 'DashboardController@index');
$route->get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

/**
 * Authentication
 * The User should be able to visit a page with a login form, submit a login request
 * to said form and also visit a route to log out of the app.
 */
$route->get('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
$route->post('/login', 'Auth\AuthController@postLogin');
$route->get('/logout', ['as' => 'logout', 'uses', 'Auth\AuthController@getLogout']);

/**
 * Provide a route to a registration form as well as
 * handling for new User registration.
 */
$route->get('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
$route->post('/register', 'Auth\AuthController@Register');

/**
 * Account
 */
// The Account Create page.
$route->get('/account/create', ['as' => 'account.create', 'uses' => 'Account\CreateController@create']);

// Submit a request to make a new Account.
$route->post('/account/create', ['as' => 'account.store', 'uses' => 'Account\StoreController@store']);

// Show a page to Edit a single Account.
$route->get('/account/{id}/edit', ['as' => 'account.edit', 'uses' => 'Account\EditController@edit']);

// Submit an update request to a single Account.
$route->patch('/account/{id}/edit', ['as' => 'account.edit', 'uses' => 'Account\PatchController@patch']);

// Submit a request to view a single Account.
$route->get('/account/{id}', ['as' => 'account.show', 'uses' => 'Account\ShowController@show']);
