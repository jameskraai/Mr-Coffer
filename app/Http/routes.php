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

$route->get('/', 'WelcomeController@index');
