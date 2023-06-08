<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ChangeAddressTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_address_data_can_be_saved()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $request = new Request([
            'postcode' => '123-4567',
            'address' => '住所',
            'build' => '建物名',
        ]);

        $response = $this->post('/address/' . $item->first()->id, $request->toArray());

        $response->assertStatus(200);
    }

    public function test_varidation_is_performed_correctly()
    {
        $users = User::factory()->create();
        $this->actingAs($users);

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $invalidData = [
            'postcode' => '123', // Invalid postcode (size: 8)
            'address' => '', // Invalid address (required)
            'build' => str_repeat('a', 256), // Invalid build (max: 255)
        ];

        $response = $this->post('/address/' . $item->first()->id, $invalidData);

        $response->assertStatus(302)->assertSessionHasErrors();
}
}