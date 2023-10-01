<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Url prefix
     *
     * @var string
     */
    public const URL = '/api/roles';

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
    public function test_listing_roles(): void
    {
        // Preparation / Prepare
        Role::create(['name' => 'Role 1']);
        Role::create(['name' => 'Role 2']);
        Role::create(['name' => 'Role 3']);

        // Action / Perform
        $response = $this->getJson(self::URL);

        // Assertion / Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                0 => [
                    "id" => 1,
                    "name" => "Role 1"
                ],
                1 => [
                    "id" => 2,
                    "name" => "Role 2"
                ],
                2 => [
                    "id" => 3,
                    "name" => "Role 3"
                ]
            ]
        ]);
    }

    /**
     * Test store method
     *
     * @return void
     */
    public function test_store_roles(): void
    {
        // Preparation / Prepare
        $data = [
            'name' => 'Role Store'
        ];

        // Action / Perform
        $response = $this->postJson(self::URL, $data);

        //Asertion /Predict
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                    "name" => "Role Store"
            ]
        ]);

        $this->assertDatabaseCount('roles', 1);
        $this->assertDatabaseHas('roles', $data);
    }

        /**
     * Test show method
     *
     * @return void
     */
    public function test_show_roles(): void
    {
        // Preparation / Prepare
        $role = Role::create(['name' => 'Role Show']);

        // Action / Perform
        $response = $this->getJson(self::URL. '/'. $role->id);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    "name" => "Role Show"
            ]
        ]);
    }

    /**
     * Test store method
     *
     * @return void
     */
    public function test_update_roles(): void
    {
        // Preparation / Prepare
        $role = Role::create(['name' => 'Role 1']);

        $data = [
            'name' => 'Role Update'
        ];

        // Action / Perform
        $response = $this->putJson(self::URL. '/'. $role->id, $data);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    "name" => "Role Update"
            ]
        ]);

        $this->assertDatabaseHas('roles', $data);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function test_delete_roles(): void
    {
        // Preparation / Prepare
        $role = Role::create(['name' => 'Role 1']);

        // Action / Perform
        $response = $this->delete(self::URL. '/'. $role->id);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    "name" => "Role 1"
            ]
        ]);

        $this->assertDatabaseCount('roles', 0);
    }

    /**
     * Test assign permission to role
     *
     * @return void
     */
    public function test_assign_permission_to_role(): void
    {
        // Preparation / Prepare
        $role = Role::create(['name' => 'Role 1']);
        $permission = Permission::create(['name' => 'Permission 1']);

        $response = $this->post(self::URL. '/' . $role->id . '/permission/' . $permission->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => 'Role 1',
                'permissions' => [
                    ['name' => 'Permission 1']
                ]
            ]
        ]);

        $this->assertDatabaseCount('role_has_permissions', 1);
    }
}
