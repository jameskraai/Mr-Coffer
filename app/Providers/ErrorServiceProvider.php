<?php

namespace MrCoffer\Providers;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use Illuminate\Support\ServiceProvider;

/**
 * Class ErrorServiceProvider
 * Adds the Whoops error handling service to our application
 * should an error arise!
 */
class ErrorServiceProvider extends ServiceProvider
{
    /**
     * Indicates this provider will only
     * be loaded if it is used.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Run::class);
        $this->app->bind(JsonResponseHandler::class);
        $this->app->bind(PrettyPageHandler::class);
    }

    /**
     * Get the services provided by the Provider.
     *
     * @return array
     */
    public function provides()
    {
        $providedServices = [
            JsonResponseHandler::class,
            PrettyPageHandler::class,
            Run::class,
        ];

        return $providedServices;
    }
}
