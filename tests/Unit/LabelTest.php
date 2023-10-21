<?php

namespace Tests\Unit;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Url prefix
     *
     * @var string
     */
    public const URL = '/api/labels';


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
    public function test_listing_labels(): void
    {
        // Preparation / Prepare
        Label::create(['name' => 'Label 1', 'color' => '#FFFFFF']);
        Label::create(['name' => 'Label 2', 'color' => '#DDDDDD']);
        Label::create(['name' => 'Label 3', 'color' => '#EEEEEE']);

        // Action / Perform
        $response = $this->getJson(self::URL);

        // Assertion / Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                0 => [
                    'id' => 1,
                    'name' => 'Label 1',
                    'color' => '#FFFFFF'
                ],
                1 => [
                    'id' => 2,
                    'name' => 'Label 2',
                    'color' => '#DDDDDD'
                ],
                2 => [
                    'id' => 3,
                    'name' => 'Label 3',
                    'color' => '#EEEEEE'
                ]
            ]
        ]);
    }

    /**
     * Test store method
     *
     * @return void
     */
    public function test_store_labels(): void
    {
        // Preparation / Prepare
        $data = [
            'name' => 'Label Store',
            'color' => '#FFFFFF'
        ];

        // Action / Perform
        $response = $this->postJson(self::URL, $data);

        //Asertion /Predict
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                    'name' => 'Label Store',
                    'color' => '#FFFFFF'
            ]
        ]);

        $this->assertDatabaseCount('labels', 1);
        $this->assertDatabaseHas('labels', $data);
    }

    /**
     * Test show method
     *
     * @return void
     */
    public function test_show_labels(): void
    {
        // Preparation / Prepare
        $label = Label::create(['name' => 'Label Show']);

        // Action / Perform
        $response = $this->getJson(self::URL. '/'. $label->id);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    'name' => 'Label Show',
                    'color' => '#FFFFFF'
            ]
        ]);
    }

    /**
     * Test store method
     *
     * @return void
     */
    public function test_update_labels(): void
    {
        // Preparation / Prepare
        $label = Label::create(['name' => 'Label Update', 'color' => '#FFFFFF']);

        $data = [
            'name' => 'Label Update',
            'color' => '#FFFFFF'
        ];

        // Action / Perform
        $response = $this->putJson(self::URL. '/'. $label->id, $data);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    'name' => 'Label Update',
                    'color' => '#FFFFFF'
            ]
        ]);

        $this->assertDatabaseHas('labels', $data);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function test_delete_labels(): void
    {
        // Preparation / Prepare
        $label = Label::create(['name' => 'Label 1', 'color' => '#FFFFFF']);

        // Action / Perform
        $response = $this->delete(self::URL. '/'. $label->id);

        //Asertion /Predict
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                    'name' => 'Label 1',
                    'color' => '#FFFFFF'
            ]
        ]);

        $this->assertDatabaseCount('labels', 0);
    }
}
