<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

/**
 * Class APIResponseService.
 */
class APIResponseService
{
    /**
     * Success Response.
     *
     * @param  mixed  $data
     * @param string $message
     * @param  int  $status_code
     * @return JsonResponse
     */
    public function successResponse(mixed $data, string $message, int $status_code = Response::HTTP_OK): JsonResponse
    {
        if (!$message) {
            $message = Response::$statusTexts[$status_code];
        }

        $data = [
            'success' => true,
            'code' => $status_code,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($data, $status_code);
    }

    /**
     * Error Response.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status_code
     * @return JsonResponse
     */
    public function errorResponse(mixed $data, string $message = '', int $status_code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        if (!$message) {
            $message = Response::$statusTexts[$status_code];
        }

        $data = [
            'success' => false,
            'code' => $status_code,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($data, $status_code);
    }

    /**
     * Response with status code 200.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function okResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->successResponse($data, $message);
    }

    /**
     * Response with status code 201.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function createdResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->successResponse($data, $message, Response::HTTP_CREATED);
    }

    /**
     * Response with status code 204.
     * @param  string  $message
     * @return JsonResponse
     */
    public function noContentResponse(string $message = ''): JsonResponse
    {
        return $this->successResponse([], $message, Response::HTTP_NO_CONTENT);
    }

    /**
     * Response with status code 400.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function badRequestResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Response with status code 401.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function unauthorizedResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Response with status code 403.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function forbiddenResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Response with status code 404.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function notFoundResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_NOT_FOUND);
    }

    /**
     * Response with status code 409.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function conflictResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_CONFLICT);
    }

    /**
     * Response with status code 422.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function unprocessableResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

     /**
     * Response with status code 500.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function serverResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
