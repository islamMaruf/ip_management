<?php

namespace App\Http\Controllers;

use APIResponse;
use App\Http\Requests\LoginRequest;
use ActivityTracker;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            ActivityTracker::track("Login attempt", $request->all());
            if (!$token = auth()->attempt($request->only(['email', 'password']))) {
                return APIResponse::unauthorizedResponse([], 'Email or password do not match');
            }
            $token = $this->createNewToken($token);
            ActivityTracker::track("Login activity");
            return  $token;
        } catch (Exception $e) {
            return APIResponse::serverResponse([]);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            ActivityTracker::track("Attempt to Logout");
            auth()->logout();
            ActivityTracker::track("Logout activity");
            return APIResponse::okResponse([], 'User successfully signed out');
        } catch (Exception $e) {
            return APIResponse::serverResponse([]);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $token = $this->createNewToken(auth()->refresh());
            ActivityTracker::track("Token refresh");
            return $token;
        } catch (Exception $e) {
            if ($e->getCode() == 0) {
                return APIResponse::forbiddenResponse([]);
            }
            return APIResponse::serverResponse([]);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        try {
            return APIResponse::okResponse(auth()->user(), 'Fetch logged in user data');
        } catch (Exception $e) {
            return APIResponse::serverResponse([]);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return APIResponse::okResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24,
            'user' => auth()->user()
        ], 'Token generated successfully');
    }
}
