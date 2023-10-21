<?php

namespace App\Exceptions;

use APIResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
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
        if ($exception instanceof ValidationException) {
            $errors = $exception->errors();
            $statusCode = $exception->status ?? Response::HTTP_UNPROCESSABLE_ENTITY;
        }
        $message = Response::$statusTexts[$statusCode]  ?? $exception->getMessage();
        return APIResponse::errorResponse($errors, $message, $statusCode);
    }
}
