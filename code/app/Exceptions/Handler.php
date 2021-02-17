<?php

namespace App\Exceptions;

use App\Helpers\Facades\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            $message = $exception->validator->errors()->first();
            $errors = $exception->errors();
            $code = 422;
        } elseif ($exception instanceof AuthenticationException) {
            $message = 'Unauthenticated';
            $code = 401;
            $errors = [
                'token' => ['Unauthenticated']
            ];
        } elseif (
            $exception instanceof ModelNotFoundException
            || $exception instanceof MethodNotAllowedHttpException
            || $exception instanceof NotFoundHttpException
        ) {
            $message = 'Not Found';
            $code = 404;
            $errors = [
                'route' => ['Cannot find']
            ];
        } elseif (
            $exception instanceof \LogicException
            || $exception instanceof QueryException
            || $exception instanceof \RuntimeException
            || $exception instanceof \InvalidArgumentException
        ) {
            $message = $exception->getMessage();
            $code = 422;
            $errors = [
                'data' => [$exception->getMessage()]
            ];
        } else {
            $code = 500;
            $message = 'Something Went Wrong';
            $errors = [
                'failed' => ['Something Went Wrong']
            ];
        }

        if (config('app.debug')) {
            $message = $message ?? $exception->getMessage();
            $errors['failed'] = [$exception->getMessage()];
            $errors['line'] = $exception->getLine();
            $errors['trace'] = $exception->getTrace();
        }

        return ApiResponse::error($code, $errors, $message);
    }
}
