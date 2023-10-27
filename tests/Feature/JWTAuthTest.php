<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class JWTAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_get_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('test_password'),
        ]);

        $response = $this->post(self::TEST_LOGIN_URL, [
            'email' => $user->email,
            'password' => 'test_password',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'success',
            'code',
            'message',
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('test_password'),
        ]);

        $response = $this->post(self::TEST_LOGIN_URL, [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_authenticated_user_can_refresh_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('test_password'),
        ]);

        $login_response = $this->post(self::TEST_LOGIN_URL, [
            'email' => $user->email,
            'password' => 'test_password',
        ]);

        $token = $login_response->json('data')['access_token'] ?? '';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(self::TEST_REFRESH_TOKEN_URL);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'success',
            'code',
            'message',
            'data' => [
                'access_token',
                'token_type',
                'expires_in',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'password' => bcrypt('test_password'),
        ]);

        $login_response = $this->post(self::TEST_LOGIN_URL, [
            'email' => $user->email,
            'password' => 'test_password',
        ]);

        $token = $login_response->json('data')['access_token'] ?? '';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(self::TEST_LOGOUT_URL);

        $response->assertStatus(Response::HTTP_OK);
    }
}
