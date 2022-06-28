<?php

namespace App\Exceptions;

use Throwable;
use ArinaSystems\JsonResponse\Traits\JsonHandler;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use JsonHandler;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        OAuthServerException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request                     $request
     * @param  \Throwable                                   $exception
     * @throws \Throwable
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            return $this->renderForJson($exception);
        }

        return parent::render($request, $exception);
    }
}
