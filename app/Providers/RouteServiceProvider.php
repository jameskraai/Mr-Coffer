<?php

namespace MrCoffer\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'MrCoffer\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @param Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param Router $router
     *
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        /**
         * Callback function for the group method on the Router
         * where we mass assign Http Routes for our app.
         *
         * @param Router $route
         *
         * @return void
         */
        $routeGroupCallback = function ($route) {
            require app_path('Http/routes.php');
        };

        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], $routeGroupCallback);
    }
}
