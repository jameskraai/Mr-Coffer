<?php

namespace MrCoffer\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector as Redirect;

/**
 * Class RedirectIfAuthenticated
 * Responsible for checking if our User is authenticated and if so
 * then routes them to the dashboard route.
 */
class RedirectIfAuthenticated
{
    /**
     * Authentication Management service, surprise!
     *
     * @var AuthManager
     */
    protected $authManager;

    /**
     * Useful for redirecting our User to a named
     * route depending on their current
     * authentication state.
     *
     * @var Redirect
     */
    protected $redirect;

    /**
     * RedirectIfAuthenticated constructor.
     *
     * @param AuthManager $authManager
     * @param Redirect    $redirect
     */
    public function __construct(AuthManager $authManager, Redirect $redirect)
    {
        $this->authManager = $authManager;
        $this->redirect = $redirect;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request      $request
     * @param Closure      $next
     * @param string|null  $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($this->authManager->guard($guard)->check()) {
            return $this->redirect->route('dashboard');
        }

        return $next($request);
    }
}
