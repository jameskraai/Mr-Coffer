<?php

namespace MrCoffer\Exceptions;

use Exception;
use Whoops\Run;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  Exception  $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request   $request
     * @param  Exception $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param  \Exception  $exception
     * @return mixed
     */
    protected function convertExceptionToResponse(Exception $exception)
    {
        $handler = $this->container->make(PrettyPageHandler::class);

        if (request()->wantsJson()) {
            $handler = $this->container->make(JsonResponseHandler::class);
        }

        if (config('app.debug')) {
            $whoops = $this->container->make(Run::class);
            $whoops->pushHandler($handler);

            return response()->make(
                $whoops->handleException($exception),
                method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500,
                method_exists($exception, 'getHeaders') ? $exception->getHeaders() : []
            );
        }

        return parent::convertExceptionToResponse($exception);
    }
}
