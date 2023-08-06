<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Url prefix
     *
     * @var string
     */
    public const URL = '/api/users';

    private User $loggedUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and log them in using Sanctum
        $this->loggedUser = User::factory()->create();
        Sanctum::actingAs($this->loggedUser);
    }

    /**
     * Test listing method
     *
     * return @void
     */
    public function test_listing_users(): void
    {
        // Preparation / Prepare
        User::create([
            'name' => 'User 1',
            'email' => 'example1@example.com',
            'password' => '12345678'
        ]);
        User::create([
            'name' => 'User 2',
            'email' => 'example2@example.com',
            'password' => '12345678'
        ]);
        User::create([
            'name' => 'User 3',
            'email' => 'example3@example.com',
            'password' => '12345678'
        ]);

        // Action / Perform
        $response = $this->getJson(self::URL);

        // Assertion / Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                0 => [
                    'name' => $this->loggedUser->name,
                    'email' => $this->loggedUser->email
                ],
                1 => [
                    'name' => 'User 1',
                    'email' => 'example1@example.com',
                ],
                2 => [
                    'name' => 'User 2',
                    'email' => 'example2@example.com',
                ],
                3 => [
                    'name' => 'User 3',
                    'email' => 'example3@example.com',
                ]
            ]
        ]);
    }

    /**
     * Test store method
     *
     * @return void
     */
    public function test_store_users(): void
    {
        // Preparation / Prepare
        $data = [
            'name' => 'User Store',
            'email' => 'example@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];


        // Action / Perform
        $response = $this->postJson(self::URL, $data);

        //Asertion /Predict
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => "User Store",
                'email' => 'example@example.com',
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'User Store',
            'email' => 'example@example.com',
        ]);
    }

    /**
     * Test show method
     *
     * @return void
     */
    public function test_show_users(): void
    {
        // Preparation / Prepare
        $user = User::create([
            'name' => 'User Show',
            'email' => 'example@example.com',
            'password' => '12345678'
        ]);

        // Action / Perform
        $response = $this->getJson(self::URL. '/'. $user->id);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => "User Show",
                'email' => 'example@example.com',
            ]
        ]);
    }

    /**
     * Test store method
     *
     * @return void
     */
    public function test_update_users(): void
    {
        // Preparation / Prepare
        $user = User::create([
            'name' => 'User 1',
            'email' => 'example@example.com',
            'password' => '12345678'
        ]);

        $data = [
            'name' => 'User Update',
            'email' => 'example@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        // Action / Perform
        $response = $this->putJson(self::URL. '/'. $user->id, $data);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => 'User Update',
                'email' => 'example@example.com',
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'User Update',
            'email' => 'example@example.com'
        ]);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function test_delete_users(): void
    {
        // Preparation / Prepare
        $user = User::create([
            'name' => 'User 1',
            'email' => 'example@example.com',
            'password' => '12345678'
        ]);

        // Action / Perform
        $response = $this->delete(self::URL. '/'. $user->id);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => "User 1",
                'email' => 'example@example.com'
            ]
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => "User 1",
            'email' => 'example@example.com'
        ]);
    }
}
