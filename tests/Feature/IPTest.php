<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\IP;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class IPTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_user_can_fetch_ip()
    {
        IP::factory()->count(5)->create();
        $response = $this->get(self::TEST_IP_URL);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'IPs fetched successfully']);
        $response->assertJsonCount(5, 'data');
    }

    public function test_user_can_store_ip()
    {
        $data = [
            'ip' => '127.0.0.1',
            'comment' => 'Test IP',
        ];

        $response = $this->post(self::TEST_IP_URL, $data);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'IP created successfully']);

        $this->assertDatabaseHas('ips', $data);
    }

    public function test_user_can_fetch_single_ip()
    {
        $ip =  IP::factory()->create();

        $response = $this->get(self::TEST_IP_URL . "/{$ip->id}");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'IP fetch successfully']);
        $response->assertJson(['data' => ['ip' => $ip->ip]]);
    }

    public function test_user_can_update_ip()
    {
        $ip =  IP::factory()->create();
        $newData = [
            'ip' => '192.168.0.1',
            'comment' => 'Updated IP',
        ];

        $response = $this->patch(self::TEST_IP_URL . "/{$ip->id}", $newData);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'IP updated successfully']);

        $this->assertDatabaseHas('ips', $newData);
    }

    public function test_user_can_delete_ip()
    {
        $ip =  IP::factory()->create();

        $response = $this->delete(self::TEST_IP_URL . "/{$ip->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('ips', ['id' => $ip->id]);
    }
}
