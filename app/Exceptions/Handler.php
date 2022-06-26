<?php

namespace App\Exceptions;

use App\Http\Controllers\BaseController;
use \Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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

        $this->renderable(function (UnauthorizedException $e, $request) {
            $response =  new BaseController;
            return $response->handleError('You do not have the required authorization.','spatie',403);
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            $response =  new BaseController;
            return $response->handleError('You do not have the required abilities authorization','sanctum',403);
        });
    }

}
