<?php

namespace App\Http\Middleware;

use APIResponse;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            $message = '';
            if ($e instanceof TokenInvalidException) {
                $message = 'Token is Invalid';
            } elseif ($e instanceof TokenExpiredException) {
                $message = 'Token is Expired';
            } else {
                $message = 'Authorization Token not found';
            }
            return APIResponse::unauthorizedResponse([], $message);
        }
        return $next($request);
    }
}
