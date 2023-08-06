<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Url prefix
     *
     * @var string
     */
    public const URL = '/api/auth';

    /**
     * Test login method
     *
     * return @void
     */
    public function test_login(): void
    {
        // Preparation / Prepare
        $user = User::create([
            'name' => 'User 1',
            'email' => 'example1@example.com',
            'password' => '12345678'
        ]);

        // Action / Perform
        $response = $this->postJson(self::URL. '/login', [
            'email' => 'example1@example.com',
            'password' => '12345678'
        ]);

        // Assertion / Predict
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
        $response->assertJson([
            'data' => [
                "id" => 1,
                'name' => 'User 1',
            ],
        ]);
    }

    /**
     * Test logout method
     *
     * @return void
     */
    public function test_logout(): void
    {
        // Preparation / Prepare
        $user = User::create([
            'name' => 'User 1',
            'email' => 'example1@example.com',
            'password' => '12345678'
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        // Action / Perform
        $response = $this->postJson(self::URL . '/logout', [], [
            'Authorization' => 'Bearer '. $token
        ]);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Logged out'
        ]);
    }
}
