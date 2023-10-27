<?php

namespace App\Http\Controllers;

use APIResponse;
use App\Http\Requests\LoginRequest;
use ActivityLogger;
use ActivityTracker;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (! $token = auth()->attempt($request->only(['email','password']))) {
            return APIResponse::unauthorizedResponse([], 'Email or password do not match');
        }
        $token = $this->createNewToken($token);
        ActivityTracker::track("Login activity");
        return  $token;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        ActivityTracker::track("Attempt to Logout");
        auth()->logout();
        ActivityTracker::track("Logout activity");
        return APIResponse::okResponse([], 'User successfully signed out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = $this->createNewToken(auth()->refresh());
        ActivityTracker::track("Token refresh");
        return $token;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return APIResponse::okResponse(auth()->user(), 'Fetch logged in user data');
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
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ], 'Token generated successfully');
    }
}
