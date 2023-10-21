<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use App\Traits\APIResponseTrait;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use APIResponseTrait;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
/**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            return $this->handleApiException($exception);
        }
            return parent::render($request, $exception);
    }

    private function handleApiException($exception)
    {
        $errors = [];
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
        $message = Response::$statusTexts[$statusCode]  ?? $exception->getMessage();
        if ($exception instanceof ValidationException) {
            $errors = $exception->errors();
        }
        return $this->errorResponse($errors, $message, $statusCode);
    }
}
