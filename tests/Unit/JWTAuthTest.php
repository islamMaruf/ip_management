<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class JWTAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_get_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('test_password'),
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'test_password',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
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

        $response = $this->post('/api/auth/login', [
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

        $login_response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'test_password',
        ]);

        $token = $login_response->json('data')['access_token'] ?? '';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/auth/refresh');

        $response->assertStatus(Response::HTTP_CREATED);
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

        $login_response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'test_password',
        ]);

        $token = $login_response->json('data')['access_token'] ?? '';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/auth/logout');

        $response->assertStatus(Response::HTTP_OK);
    }
}
