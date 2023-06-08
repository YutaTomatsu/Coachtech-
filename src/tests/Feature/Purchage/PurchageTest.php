<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class PurchageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_redirected_to_login()
    {
        $users = User::factory()->create();
        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->get('/purchage/' . $item->first()->id);

        $response->assertStatus(302)->assertRedirect('login');
    }

    public function test_user_can_access_change_address()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->get('/address/' . $item->first()->id);

        $response->assertStatus(200);
    }


    public function test_user_can_access_credit_card_payment()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->get('/card/' . $item->first()->id);

        $response->assertStatus(200);
    }

    public function test_user_can_access_bank_payment()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->get('/bank/' . $item->first()->id);

        $response->assertStatus(200);
    }

    public function test_user_can_access_convenience_payment()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->get('/convenience/' . $item->first()->id);

        $response->assertStatus(200);
    }


}
