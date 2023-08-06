<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Url prefix
     *
     * @var string
     */
    public const URL = '/api/permissions';


    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and log them in using Sanctum
        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * Test listing method
     *
     * return @void
     */
    public function test_listing_permissions(): void
    {
        // Preparation / Prepare
        Permission::create(['name' => 'Permission 1']);
        Permission::create(['name' => 'Permission 2']);
        Permission::create(['name' => 'Permission 3']);

        // Action / Perform
        $response = $this->getJson(self::URL);

        // Assertion / Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                0 => [
                    "id" => 1,
                    "name" => "Permission 1"
                ],
                1 => [
                    "id" => 2,
                    "name" => "Permission 2"
                ],
                2 => [
                    "id" => 3,
                    "name" => "Permission 3"
                ]
            ]
        ]);
    }

    /**
     * Test store method
     *
     * @return void
     */
    public function test_store_permissions(): void
    {
        // Preparation / Prepare
        $data = [
            'name' => 'Permission Store'
        ];

        // Action / Perform
        $response = $this->postJson(self::URL, $data);

        //Asertion /Predict
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                    "name" => "Permission Store"
            ]
        ]);

        $this->assertDatabaseCount('permissions', 1);
        $this->assertDatabaseHas('permissions', $data);
    }

    /**
     * Test show method
     *
     * @return void
     */
    public function test_show_permissions(): void
    {
        // Preparation / Prepare
        $permission = Permission::create(['name' => 'Permission Show']);

        // Action / Perform
        $response = $this->getJson(self::URL. '/'. $permission->id);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    "name" => "Permission Show"
            ]
        ]);
    }

    /**
     * Test store method
     *
     * @return void
     */
    public function test_update_permissions(): void
    {
        // Preparation / Prepare
        $permission = Permission::create(['name' => 'Permission 1']);

        $data = [
            'name' => 'Permission Update'
        ];

        // Action / Perform
        $response = $this->putJson(self::URL. '/'. $permission->id, $data);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    "name" => "Permission Update"
            ]
        ]);

        $this->assertDatabaseHas('permissions', $data);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function test_delete_permissions(): void
    {
        // Preparation / Prepare
        $permission = Permission::create(['name' => 'Permission 1']);

        // Action / Perform
        $response = $this->delete(self::URL. '/'. $permission->id);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    "name" => "Permission 1"
            ]
        ]);

        $this->assertDatabaseCount('permissions', 0);
    }
}
