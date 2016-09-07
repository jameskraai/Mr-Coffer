<?php

namespace MrCoffer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class VerifyWantsJson
 * Verifies that the incoming request wants Json, if it does not then route back
 * to the web component.
 */
class VerifyWantsJson
{
    /**
     * Checks if the incoming Request wants Json, if it does
     * not then route to the web component.
     *
     * @param  Request  $request Http Request service.
     * @param  Closure  $next    Continue on.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->wantsJson()) {
            return $next($request);
        }

        return redirect(env('APP_WEB'));
    }
}
