<?php

namespace MrCoffer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Redirector as Redirect;

/**
 * Class Authenticate
 * This middleware is responsible for determining if a visitor is a guest and enforcing
 * the rules of access if they are. If the current User is not a guest
 * then the middleware moves on.
 *
 * @package MrCoffer\Http\Middleware
 */
class Authenticate
{
    /**
     * Authentication Management service.
     *
     * @var AuthManager
     */
    protected $authManager;

    /**
     * Http Response service.
     *
     * @var Response
     */
    protected $response;

    /**
     * Useful for redirecting our User to a named route
     * if they are not logged in.
     *
     * @var Redirect
     */
    protected $redirect;

    /**
     * Authenticate constructor.
     *
     * @param AuthManager $authManager
     * @param Response    $response
     * @param Redirect    $redirect
     */
    public function __construct(AuthManager $authManager, Response $response, Redirect $redirect)
    {
        $this->authManager = $authManager;
        $this->response = $response;
        $this->redirect = $redirect;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($this->authManager->guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {

                $this->response->setContent('Unauthorized.');
                $this->response->setStatusCode(401);

                return $this->response->send();

            } else {

                return $this->redirect->guest('login');
            }
        }

        return $next($request);
    }
}
