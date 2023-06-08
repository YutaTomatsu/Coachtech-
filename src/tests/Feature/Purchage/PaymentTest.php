<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class PaymentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_success_payment()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $addressData = [
            'postcode' => '123-4567',
            'address' => '住所',
            'build' => '建物名',
        ];

        session()->put('addresses', (object)$addressData);

        $response = $this->post('/payment-success/' . $item->first()->id);

        $response->assertStatus(200);
    }


}
